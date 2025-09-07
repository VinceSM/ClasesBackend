<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idMembresia = $_POST['idMembresia'] ?? null;

if (!$idMembresia) {
    echo json_encode(["success" => false, "message" => "Falta el id de la membresía"]);
    exit;
}

$sql = "UPDATE membresias SET deletedAt = CURRENT_TIMESTAMP WHERE idMembresia=? AND deletedAt IS NULL";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idMembresia);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Membresía eliminada"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al eliminar membresía"]);
}
?>
