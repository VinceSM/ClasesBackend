<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$idCiudad = $data['idCiudad'] ?? null;
$ciudad   = $data['ciudad'] ?? null;

if (!$idCiudad || !$ciudad) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos requeridos (idCiudad y ciudad)'
    ]);
    exit;
}

$sql = "UPDATE ciudades 
        SET ciudad = ?, updatedAt = CURRENT_TIMESTAMP 
        WHERE idCiudad = ? AND deletedAt IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $ciudad, $idCiudad);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Ciudad modificada correctamente'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al modificar la ciudad'
    ]);
}

$stmt->close();
$conn->close();
