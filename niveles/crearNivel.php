<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = trim($_POST["tipo"]);

    if (!empty($tipo)) {
        $sql = "INSERT INTO niveles (tipo) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $tipo);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Nivel creado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear nivel"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "El tipo de nivel es obligatorio"]);
    }
}

$conn->close();
?>
