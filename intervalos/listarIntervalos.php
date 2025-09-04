<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$sql = "SELECT * FROM intervalos WHERE deletedAt IS NULL";
$result = $conn->query($sql);

$intervalos = [];
while ($row = $result->fetch_assoc()) {
    $intervalos[] = $row;
}

echo json_encode(['success' => true, 'data' => $intervalos]);

$conn->close();
