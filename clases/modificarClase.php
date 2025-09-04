<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Recibir parámetros por POST
$idClase = $_POST['idClase'] ?? null;
$maxestudiante = $_POST['maxestudiante'] ?? null;
$Nivel_idNivel = $_POST['Nivel_idNivel'] ?? null;
$Horarios_idHorarios = $_POST['Horarios_idHorarios'] ?? null;

if (!$idClase || !$maxestudiante || !$Nivel_idNivel || !$Horarios_idHorarios) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
    exit;
}

$sql = "UPDATE clases SET maxestudiante=?, Nivel_idNivel=?, Horarios_idHorarios=?, updatedAt=NOW() WHERE idClases=? AND deletedAt IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $maxestudiante, $Nivel_idNivel, $Horarios_idHorarios, $idClase);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Clase modificada']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al modificar clase']);
}

$stmt->close();
$conn->close();
?>
