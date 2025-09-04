<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Recibir parámetros por POST
$maxestudiante = $_POST['maxestudiante'] ?? null;
$Nivel_idNivel = $_POST['Nivel_idNivel'] ?? null;
$Horarios_idHorarios = $_POST['Horarios_idHorarios'] ?? null;

if (!$maxestudiante || !$Nivel_idNivel || !$Horarios_idHorarios) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
    exit;
}

$sql = "INSERT INTO clases (maxestudiante, Nivel_idNivel, Horarios_idHorarios) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $maxestudiante, $Nivel_idNivel, $Horarios_idHorarios);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Clase creada', 'idClase' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al crear clase']);
}

$stmt->close();
$conn->close();
?>
