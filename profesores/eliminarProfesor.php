<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idProfesor = $_POST['idProfesores'] ?? null;

if (!$idProfesor) {
    echo json_encode(["success" => false, "message" => "Falta el id del profesor"]);
    exit;
}

$sql = "UPDATE profesores SET deletedAt=CURRENT_TIMESTAMP WHERE idProfesores=? AND deletedAt IS NULL";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idProfesor);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Profesor eliminado"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al eliminar profesor"]);
}
?>
