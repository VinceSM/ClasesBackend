<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idNivel = $_POST['idNivel'] ?? null;
$tipo = $_POST['tipo'] ?? null;

if (!$idNivel || !$tipo) {
    echo json_encode(["success" => false, "message" => "Faltan datos obligatorios"]);
    exit;
}

$sql = "UPDATE niveles SET tipo=?, updatedAt=CURRENT_TIMESTAMP WHERE idNivel=? AND deletedAt IS NULL";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("si", $tipo, $idNivel);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Nivel modificado"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al modificar nivel"]);
}
?>
