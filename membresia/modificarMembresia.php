<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idMembresia = $_POST['idMembresia'] ?? null;
$tipo = $_POST['tipo'] ?? null;
$clasesPorMes = $_POST['clasesPorMes'] ?? null;
$clasesPagadas = $_POST['clasesPagadas'] ?? null;
$debe = $_POST['debe'] ?? null;
$cantClasesDeuda = $_POST['cantClasesDeuda'] ?? null;

if (!$idMembresia) {
    echo json_encode(["success" => false, "message" => "Falta el id de la membresía"]);
    exit;
}

$sql = "UPDATE membresias SET tipo=?, clasesPorMes=?, clasesPagadas=?, debe=?, cantClasesDeuda=?, updatedAt=CURRENT_TIMESTAMP WHERE idMembresia=? AND deletedAt IS NULL";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("siiiii", $tipo, $clasesPorMes, $clasesPagadas, $debe, $cantClasesDeuda, $idMembresia);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Membresía modificada"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al modificar membresía"]);
}
?>
