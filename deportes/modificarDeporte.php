<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->idDeportes) && !empty($data->nombre)) {
    $stmt = $conexion->prepare("UPDATE deportes SET nombre = ? WHERE idDeportes = ?");
    $stmt->bind_param("si", $data->nombre, $data->idDeportes);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Deporte modificado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al modificar deporte"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Faltan datos"]);
}
$conexion->close();
?>
