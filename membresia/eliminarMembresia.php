<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID de membresía no proporcionado"]);
    exit;
}

$query = "UPDATE membresias SET deleted_at = NOW() WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Membresía eliminada correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al eliminar la membresía"]);
}

$stmt->close();
$conexion->close();
