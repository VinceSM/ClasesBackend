<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idNivel = $_POST['idNivel'] ?? null;

if (!$idNivel) {
    echo json_encode(["success" => false, "message" => "Falta el id del nivel"]);
    exit;
}

$sql = "UPDATE niveles SET deletedAt=CURRENT_TIMESTAMP WHERE idNivel=? AND deletedAt IS NULL";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idNivel);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Nivel eliminado"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al eliminar nivel"]);
}
?>
