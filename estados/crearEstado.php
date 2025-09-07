<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$estado = $data['estado'];

try {
    $stmt = $conexion->prepare("INSERT INTO estados (estado) VALUES (?)");
    $stmt->bind_param("s", $estado);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Estado creado correctamente"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
