<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idHorario = $_POST['idHorarios'] ?? null;
$fecha = $_POST['fecha'] ?? null;
$dia = $_POST['dia'] ?? null;
$inicio = $_POST['inicio'] ?? null;
$fin = $_POST['fin'] ?? null;
$disponible = $_POST['disponible'] ?? null;
$estado = $_POST['Estados_idEstados'] ?? null;

if (!$idHorario) {
    echo json_encode(["success" => false, "message" => "Falta el id del horario"]);
    exit;
}

$sql = "UPDATE horarios SET 
            fecha = ?, 
            dia = ?, 
            inicio = ?, 
            fin = ?, 
            disponible = ?, 
            Estados_idEstados = ?, 
            updatedAt = CURRENT_TIMESTAMP 
        WHERE idHorarios = ? AND deletedAt IS NULL";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssiii", $fecha, $dia, $inicio, $fin, $disponible, $estado, $idHorario);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Horario modificado"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al modificar horario"]);
}
?>
