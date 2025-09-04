<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if (!isset($_GET['fecha'])) {
    echo json_encode(["status" => "error", "message" => "Se requiere fecha"]);
    exit;
}

$fecha = $_GET['fecha'];

$sql = "SELECT h.*, e.estado 
        FROM horarios h
        INNER JOIN estados e ON h.Estados_idEstados = e.idEstados
        WHERE h.deletedAt IS NULL AND h.fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fecha);
$stmt->execute();
$result = $stmt->get_result();

$horarios = [];
while ($row = $result->fetch_assoc()) {
    $horarios[] = $row;
}

echo json_encode($horarios);
$conn->close();
?>
