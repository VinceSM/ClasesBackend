<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $celular = !empty($_POST["celular"]) ? trim($_POST["celular"]) : null;
    $dni = !empty($_POST["dni"]) ? trim($_POST["dni"]) : null;
    $edad = !empty($_POST["edad"]) ? intval($_POST["edad"]) : null;

    if (!empty($nombre) && !empty($apellido)) {
        $sql = "INSERT INTO profesores (nombre, apellido, celular, dni, edad) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $apellido, $celular, $dni, $edad);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Profesor creado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear profesor"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Nombre y apellido son obligatorios"]);
    }
}

$conn->close();
?>
