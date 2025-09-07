<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

// Recibimos los datos por POST
$fecha = $_POST['fecha'] ?? null;
$dia = $_POST['dia'] ?? null;
$inicio = $_POST['inicio'] ?? null;
$fin = $_POST['fin'] ?? null;
$disponible = $_POST['disponible'] ?? 0;
$estado = $_POST['Estados_idEstados'] ?? null;

if (!$fecha || !$dia || !$inicio || !$fin || !$estado) {
    echo json_encode(["success" => false, "message" => "Faltan datos obligatorios"]);
    exit;
}

$sql = "INSERT INTO horarios (fecha, dia, inicio, fin, disponible, Estados_idEstados) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssii", $fecha, $dia, $inicio, $fin, $disponible, $estado);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Horario creado", "idHorarios" => $stmt->insert_id]);
} else {
    echo json_encode(["success" => false, "message" => "Error al crear horario"]);
}
?>
