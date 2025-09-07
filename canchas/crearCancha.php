<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->cancha) && isset($data->indoor) && !empty($data->Deportes_idDeportes)) {
    $stmt = $conexion->prepare("INSERT INTO canchas (cancha, indoor, Deportes_idDeportes) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $data->cancha, $data->indoor, $data->Deportes_idDeportes);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Cancha creada correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al crear cancha"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}
$conexion->close();
?>
