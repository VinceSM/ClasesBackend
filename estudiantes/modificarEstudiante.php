<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['idEstudiantes'];
$nombre = $data['nombre'];
$apellido = $data['apellido'];
$celular = $data['celular'];
$edad = $data['edad'];
$dni = $data['dni'];
$nacimiento = $data['nacimiento'];
$nivelId = $data['Nivel_idNivel'] ?? null;
$membresiaId = $data['Membresia_idMembresia'] ?? null;

try {
    $stmt = $conexion->prepare("UPDATE estudiantes 
        SET nombre=?, apellido=?, celular=?, edad=?, dni=?, nacimiento=?, 
            Nivel_idNivel=?, Membresia_idMembresia=?, updatedAt=NOW() 
        WHERE idEstudiantes=?");
    $stmt->bind_param("sssissiii", $nombre, $apellido, $celular, $edad, $dni, $nacimiento, $nivelId, $membresiaId, $id);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Estudiante modificado correctamente"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
