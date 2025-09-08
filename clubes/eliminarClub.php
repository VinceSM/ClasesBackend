<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idClub = $_POST['idClub'] ?? null;

if (!$idClub) {
    echo json_encode(["error" => "ID de club requerido"]);
    exit;
}

// Eliminación lógica
$sql = "UPDATE clubes SET deletedAt = NOW() WHERE idClub = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idClub);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
