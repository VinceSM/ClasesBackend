<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idReserva = $_GET['idReserva'] ?? null;

if (!$idReserva) {
    echo json_encode(["error" => "ID de reserva requerido"]);
    exit;
}

$sql = "SELECT c.idCanchas, c.cancha, c.indoor, c.Deportes_idDeportes
        FROM reservas_has_canchas rc
        INNER JOIN canchas c ON rc.Canchas_idCanchas = c.idCanchas
        WHERE rc.Reservas_idReservas = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idReserva);
$stmt->execute();
$result = $stmt->get_result();

$canchas = [];
while ($row = $result->fetch_assoc()) {
    $canchas[] = $row;
}

echo json_encode($canchas);

$stmt->close();
$conn->close();
?>
