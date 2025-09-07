<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->cancha) && isset($data->indoor)) {
    $stmt = $conexion->prepare("INSERT INTO canchas (cancha, indoor) VALUES (?, ?)");
    $stmt->bind_param("ii", $data->cancha, $data->indoor);

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
