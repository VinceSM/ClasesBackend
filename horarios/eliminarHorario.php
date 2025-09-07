<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idHorario = $_POST['idHorarios'] ?? null;

if (!$idHorario) {
    echo json_encode(["success" => false, "message" => "Falta el id del horario"]);
    exit;
}

$sql = "UPDATE horarios SET deletedAt = CURRENT_TIMESTAMP WHERE idHorarios = ? AND deletedAt IS NULL";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idHorario);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Horario eliminado"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al eliminar horario"]);
}
?>
