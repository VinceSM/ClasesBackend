<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID de estado no proporcionado"]);
    exit;
}

$query = "UPDATE estados SET deleted_at = NOW() WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Estado eliminado correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al eliminar el estado"]);
}

$stmt->close();
$conexion->close();
