<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $estado = trim($_POST["estado"]);

    if (!empty($estado)) {
        $sql = "INSERT INTO estados (estado) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $estado);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Estado creado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear estado"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "El estado es obligatorio"]);
    }
}

$conn->close();
?>
