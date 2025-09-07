<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$idEstado = $data['idEstado'];
$estado = $data['estado'];

try {
    $stmt = $conexion->prepare("UPDATE estados SET estado=? WHERE idEstado=?");
    $stmt->bind_param("si", $estado, $idEstado);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Estado modificado correctamente"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
