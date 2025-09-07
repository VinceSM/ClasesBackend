<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$tipo = $_POST['tipo'] ?? null;
$clasesPorMes = $_POST['clasesPorMes'] ?? 0;
$clasesPagadas = $_POST['clasesPagadas'] ?? 0;
$debe = $_POST['debe'] ?? 0;
$cantClasesDeuda = $_POST['cantClasesDeuda'] ?? 0;

if (!$tipo) {
    echo json_encode(["success" => false, "message" => "Falta el tipo de membresía"]);
    exit;
}

$sql = "INSERT INTO membresias (tipo, clasesPorMes, clasesPagadas, debe, cantClasesDeuda) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("siiii", $tipo, $clasesPorMes, $clasesPagadas, $debe, $cantClasesDeuda);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Membresía creada", "idMembresia" => $stmt->insert_id]);
} else {
    echo json_encode(["success" => false, "message" => "Error al crear membresía"]);
}
?>
