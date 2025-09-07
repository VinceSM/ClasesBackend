<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idProfesor = $_POST['idProfesores'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$apellido = $_POST['apellido'] ?? null;
$celular = $_POST['celular'] ?? null;
$dni = $_POST['dni'] ?? null;
$edad = $_POST['edad'] ?? null;

if (!$idProfesor) {
    echo json_encode(["success" => false, "message" => "Falta el id del profesor"]);
    exit;
}

$sql = "UPDATE profesores SET nombre=?, apellido=?, celular=?, dni=?, edad=?, updatedAt=CURRENT_TIMESTAMP WHERE idProfesores=? AND deletedAt IS NULL";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssiii", $nombre, $apellido, $celular, $dni, $edad, $idProfesor);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Profesor modificado"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al modificar profesor"]);
}
?>
