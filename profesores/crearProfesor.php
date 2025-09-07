<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$nombre = $_POST['nombre'] ?? null;
$apellido = $_POST['apellido'] ?? null;
$celular = $_POST['celular'] ?? null;
$dni = $_POST['dni'] ?? null;
$edad = $_POST['edad'] ?? null;

if (!$nombre || !$apellido) {
    echo json_encode(["success" => false, "message" => "Faltan datos obligatorios"]);
    exit;
}

$sql = "INSERT INTO profesores (nombre, apellido, celular, dni, edad) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssii", $nombre, $apellido, $celular, $dni, $edad);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Profesor creado", "idProfesores" => $stmt->insert_id]);
} else {
    echo json_encode(["success" => false, "message" => "Error al crear profesor"]);
}
?>
