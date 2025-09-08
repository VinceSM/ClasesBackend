<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$nombre = $_POST['nombre'] ?? null;
$sede = $_POST['sede'] ?? null;
$direccion = $_POST['direccion'] ?? null;
$ciudad = $_POST['ciudad'] ?? null;

if (!$nombre || $sede === null || !$direccion) {
    echo json_encode(["error" => "Faltan datos obligatorios"]);
    exit;
}

$sql = "INSERT INTO clubes (nombre, sede, direccion, ciudad) 
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siss", $nombre, $sede, $direccion, $ciudad);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "idClub" => $stmt->insert_id]);
} else {
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
