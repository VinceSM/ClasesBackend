<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idReserva = $_GET['idReserva'] ?? null;

if (!$idReserva) {
    echo json_encode(["error" => "ID de reserva requerido"]);
    exit;
}

$sql = "SELECT cl.idClases, cl.nombre, cl.maxestudiante, cl.privada
        FROM reservas_has_clases rc
        INNER JOIN clases cl ON rc.Clases_idClases = cl.idClases
        WHERE rc.Reservas_idReservas = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idReserva);
$stmt->execute();
$result = $stmt->get_result();

$clases = [];
while ($row = $result->fetch_assoc()) {
    $clases[] = $row;
}

echo json_encode($clases);

$stmt->close();
$conn->close();
?>
