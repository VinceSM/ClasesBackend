<?php

require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Se requiere idClases"]);
    exit;
}

$id = intval($_GET['id']);
$sql = "UPDATE clases SET deleted_at = NOW() WHERE idClases = $id";

if ($conn->query($sql)) {
    echo json_encode(["message" => "Clase eliminada"]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
