<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["idEstados"]);

    if ($id > 0) {
        $sql = "UPDATE estados SET deletedAt = NOW() WHERE idEstados = ? AND deletedAt IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Estado eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar estado"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "ID inválido"]);
    }
}

$conn->close();
?>
