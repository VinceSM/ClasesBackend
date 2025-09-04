<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

$idIntervalo = $_GET['idIntervalo'] ?? null;

if (!$idIntervalo) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Falta el parámetro idIntervalo'
    ]);
    exit;
}

$sql = "SELECT * 
        FROM intervalos 
        WHERE idIntervalo = ? 
          AND activo = 1 
          AND deletedAt IS NULL";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idIntervalo);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'data' => $row
    ]);
} else {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Intervalo no encontrado o no está activo'
    ]);
}

$stmt->close();
$conn->close();
