<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["idDeportes"]);

    if ($id > 0) {
        $sql = "UPDATE deportes SET deletedAt = NOW() WHERE idDeportes = ? AND deletedAt IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Deporte eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar deporte"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "ID inválido"]);
    }
}

$conn->close();
?>
