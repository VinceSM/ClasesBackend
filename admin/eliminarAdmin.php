<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->idAdmin)) {
    $stmt = $conexion->prepare("UPDATE admin SET deletedAt = CURRENT_TIMESTAMP WHERE idAdmin = ?");
    $stmt->bind_param("i", $data->idAdmin);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Admin eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar admin"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Falta idAdmin"]);
}

$conexion->close();
?>
