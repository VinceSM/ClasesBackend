<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["idEstados"]);
    $estado = trim($_POST["estado"]);

    if ($id > 0 && !empty($estado)) {
        $sql = "UPDATE estados SET estado = ? WHERE idEstados = ? AND deletedAt IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $estado, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Estado actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al actualizar estado"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
    }
}

$conn->close();
?>
