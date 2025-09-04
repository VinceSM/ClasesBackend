<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$idIntervalo = $data['idIntervalo'] ?? null;

if (!$idIntervalo) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Falta el idIntervalo']);
    exit;
}

$sql = "UPDATE intervalos SET deletedAt = CURRENT_TIMESTAMP, activo = 0 WHERE idIntervalo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idIntervalo);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Intervalo eliminado correctamente']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el intervalo']);
}

$stmt->close();
$conn->close();
