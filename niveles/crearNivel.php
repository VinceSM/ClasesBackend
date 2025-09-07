<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$tipo = $_POST['tipo'] ?? null;

if (!$tipo) {
    echo json_encode(["success" => false, "message" => "Falta el tipo de nivel"]);
    exit;
}

$sql = "INSERT INTO niveles (tipo) VALUES (?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $tipo);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Nivel creado", "idNivel" => $stmt->insert_id]);
} else {
    echo json_encode(["success" => false, "message" => "Error al crear nivel"]);
}
?>
