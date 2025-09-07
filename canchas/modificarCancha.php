<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->idCancha) && !empty($data->cancha) && isset($data->indoor) && !empty($data->Deportes_idDeportes)) {
    $stmt = $conexion->prepare("UPDATE canchas SET cancha = ?, indoor = ?, Deportes_idDeportes = ? WHERE idCancha = ?");
    $stmt->bind_param("siii", $data->cancha, $data->indoor, $data->Deportes_idDeportes, $data->idCancha);

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
