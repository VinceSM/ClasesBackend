<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idReserva = $_GET['idReserva'] ?? null;

if (!$idReserva) {
    echo json_encode(["error" => "ID de reserva requerido"]);
    exit;
}

$sql = "SELECT p.idProfesores, p.nombre, p.apellido, p.especialidad
        FROM reservas_has_profesores rp
        INNER JOIN profesores p ON rp.Profesores_idProfesores = p.idProfesores
        WHERE rp.Reservas_idReservas = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idReserva);
$stmt->execute();
$result = $stmt->get_result();

$profesores = [];
while ($row = $result->fetch_assoc()) {
    $profesores[] = $row;
}

echo json_encode($profesores);

$stmt->close();
$conn->close();
?>
