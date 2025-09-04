<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$sql = "SELECT * FROM deportes WHERE deletedAt IS NULL";
$result = $conn->query($sql);

$deportes = [];
while ($row = $result->fetch_assoc()) {
    $deportes[] = $row;
}

echo json_encode(['success' => true, 'data' => $deportes]);

$conn->close();
