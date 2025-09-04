<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$idIntervalo = $data['idIntervalo'] ?? null;
$idCancha    = $data['idCancha'] ?? null;
$idClase     = $data['idClase'] ?? null;
$inicio      = $data['inicio'] ?? null;
$fin         = $data['fin'] ?? null;
$duracion    = $data['duracion'] ?? null;
$idEstado = $data['idEstado'] ?? null;

if (!$idIntervalo) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Falta el idIntervalo']);
    exit;
}

$sql = "UPDATE intervalos 
        SET idCancha = ?, idClase = ?, inicio = ?, fin = ?, duracion = ?, idEstado = ?, updatedAt = CURRENT_TIMESTAMP 
        WHERE idIntervalo = ? AND deletedAt IS NULL";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iissiii", $idCancha, $idClase, $inicio, $fin, $duracion, $idEstado, $idIntervalo);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Intervalo actualizado correctamente']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el intervalo']);
}

$stmt->close();
$conn->close();
