<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["idNivel"]);
    $tipo = trim($_POST["tipo"]);

    if ($id > 0 && !empty($tipo)) {
        $sql = "UPDATE niveles SET tipo = ? WHERE idNivel = ? AND deletedAt IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $tipo, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Nivel actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar nivel"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
    }
}

$conn->close();
?>
