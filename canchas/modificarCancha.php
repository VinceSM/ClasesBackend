<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->idCancha) && !empty($data->cancha) && isset($data->indoor)) {
    $stmt = $conexion->prepare("UPDATE canchas SET cancha = ?, indoor = ? WHERE idCancha = ? AND deletedAt IS NULL");
    $stmt->bind_param("iii", $data->cancha, $data->indoor, $data->idCancha);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Cancha modificada correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al modificar cancha"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}
$conexion->close();
?>
