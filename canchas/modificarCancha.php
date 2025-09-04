<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$idCancha = $data['idCancha'] ?? null;
$nombre   = $data['nombre'] ?? null;
$techada  = $data['techada'] ?? null;
$idCiudad = $data['idCiudad'] ?? null;
$idDeporte = $data['idDeporte'] ?? null;

if (!$idCancha) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Falta el idCancha']);
    exit;
}

$sql = "UPDATE canchas 
        SET nombre = ?, techada = ?, idCiudad = ?, idDeporte = ?, updatedAt = CURRENT_TIMESTAMP 
        WHERE idCancha = ? AND deletedAt IS NULL";

$stmt = $conn->prepare($sql);
$stmt->bind_param("siiii", $nombre, $techada, $idCiudad, $idDeporte, $idCancha);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cancha modificada correctamente']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al modificar la cancha']);
}

$stmt->close();
$conn->close();
