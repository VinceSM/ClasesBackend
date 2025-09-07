<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$idCancha = $data['idCancha'] ?? null;

if (!$idCancha) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Falta el idCancha']);
    exit;
}

$sql = "UPDATE canchas SET deletedAt = CURRENT_TIMESTAMP WHERE idCancha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCancha);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cancha eliminada correctamente']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al eliminar la cancha']);
}

$stmt->close();
$conn->close();
