<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idClub = $_POST['idClub'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$sede = $_POST['sede'] ?? null;
$direccion = $_POST['direccion'] ?? null;
$ciudad = $_POST['ciudad'] ?? null;

if (!$idClub) {
    echo json_encode(["error" => "ID de club requerido"]);
    exit;
}

$sql = "UPDATE clubes 
        SET nombre = ?, sede = ?, direccion = ?, ciudad = ?, updatedAt = NOW() 
        WHERE idClub = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sissi", $nombre, $sede, $direccion, $ciudad, $idClub);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
