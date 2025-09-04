<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$idCancha = $_GET['idCancha'] ?? null;

if (!$idCancha) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Falta el parámetro idCancha']);
    exit;
}

$sql = "SELECT * FROM intervalos WHERE idCancha = ? AND deletedAt IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCancha);
$stmt->execute();
$result = $stmt->get_result();

$intervalos = [];
while ($row = $result->fetch_assoc()) {
    $intervalos[] = $row;
}

echo json_encode(['success' => true, 'data' => $intervalos]);

$stmt->close();
$conn->close();
