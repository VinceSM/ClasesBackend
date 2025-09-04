<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);

    if (!empty($nombre)) {
        $sql = "INSERT INTO deportes (nombre) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Deporte creado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear deporte"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "El nombre es obligatorio"]);
    }
}

$conn->close();
?>
