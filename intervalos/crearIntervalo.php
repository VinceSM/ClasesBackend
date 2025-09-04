<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$idCancha = $data['idCancha'] ?? null;
$idClase  = $data['idClase'] ?? null;
$inicio   = $data['inicio'] ?? null;
$fin      = $data['fin'] ?? null;
$duracion = $data['duracion'] ?? null;
$idEstado = $data['idEstado'] ?? null;

if (!$idCancha || !$idClase || !$inicio || !$fin || !$duracion) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
    exit;
}

$sql = "INSERT INTO intervalos (idCancha, idClase, inicio, fin, duracion, idEstado) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissii", $idCancha, $idClase, $inicio, $fin, $duracion, $idEstado);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Intervalo creado correctamente']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al crear el intervalo']);
}

$stmt->close();
$conn->close();
