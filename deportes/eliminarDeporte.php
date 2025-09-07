<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->idDeportes)) {
    // Soft delete
    $stmt = $conexion->prepare("UPDATE deportes SET deletedAt = NOW() WHERE idDeportes = ?");
    $stmt->bind_param("i", $data->idDeportes);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Deporte eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar deporte"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Faltan datos"]);
}
$conexion->close();
?>
