<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["idDeportes"]);
    $nombre = trim($_POST["nombre"]);

    if ($id > 0 && !empty($nombre)) {
        $sql = "UPDATE deportes SET nombre = ? WHERE idDeportes = ? AND deletedAt IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Deporte actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar deporte"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
    }
}

$conn->close();
?>
