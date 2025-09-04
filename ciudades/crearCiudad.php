<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$ciudad = $data['ciudad'] ?? null;

if (!$ciudad) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Falta el nombre de la ciudad'
    ]);
    exit;
}

$sql = "INSERT INTO ciudades (ciudad) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ciudad);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Ciudad creada correctamente',
        'idCiudad' => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al crear la ciudad'
    ]);
}

$stmt->close();
$conn->close();
