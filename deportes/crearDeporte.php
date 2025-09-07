<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nombre)) {
    $stmt = $conexion->prepare("INSERT INTO deportes (nombre) VALUES (?)");
    $stmt->bind_param("s", $data->nombre);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Deporte creado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al crear deporte"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Falta el nombre"]);
}
$conexion->close();
?>
