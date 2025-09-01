<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Se requiere idEstudiantes"]);
    exit;
}

$id = intval($_GET['id']);
$sql = "UPDATE estudiantes SET deleted_at = NOW() WHERE idEstudiantes = $id";

if ($conn->query($sql)) {
    echo json_encode(["message" => "Estudiante eliminado (soft delete)"]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
