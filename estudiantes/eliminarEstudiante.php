<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['idEstudiantes'];

try {
    $stmt = $conexion->prepare("UPDATE estudiantes SET deletedAt=NOW() WHERE idEstudiantes=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Estudiante eliminado correctamente"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
