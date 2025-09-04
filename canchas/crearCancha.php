<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$nombre   = $data['nombre'] ?? null;
$techada  = $data['techada'] ?? 1; // por defecto 1
$idCiudad = $data['idCiudad'] ?? null;

if (!$nombre || !$idCiudad) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
    exit;
}

$sql = "INSERT INTO canchas (nombre, techada, idCiudad) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $nombre, $techada, $idCiudad);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cancha creada correctamente']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al crear la cancha']);
}

$stmt->close();
$conn->close();
