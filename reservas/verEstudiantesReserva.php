<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idReserva = $_GET['idReserva'] ?? null;

if (!$idReserva) {
    echo json_encode(["error" => "ID de reserva requerido"]);
    exit;
}

$sql = "SELECT e.idEstudiantes, e.nombre, e.apellido, e.dni, e.edad
        FROM reservas_has_estudiantes re
        INNER JOIN estudiantes e ON re.Estudiantes_idEstudiantes = e.idEstudiantes
        WHERE re.Reservas_idReservas = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idReserva);
$stmt->execute();
$result = $stmt->get_result();

$estudiantes = [];
while ($row = $result->fetch_assoc()) {
    $estudiantes[] = $row;
}

echo json_encode($estudiantes);

$stmt->close();
$conn->close();
?>
