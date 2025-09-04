<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["idProfesores"]);
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $celular = !empty($_POST["celular"]) ? trim($_POST["celular"]) : null;
    $dni = !empty($_POST["dni"]) ? trim($_POST["dni"]) : null;
    $edad = !empty($_POST["edad"]) ? intval($_POST["edad"]) : null;

    if ($id > 0 && !empty($nombre) && !empty($apellido)) {
        $sql = "UPDATE profesores SET nombre = ?, apellido = ?, celular = ?, dni = ?, edad = ? 
                WHERE idProfesores = ? AND deletedAt IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $nombre, $apellido, $celular, $dni, $edad, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Profesor actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar profesor"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
    }
}

$conn->close();
?>
