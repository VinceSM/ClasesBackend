<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT idEstado, estado FROM estados";
$result = $conexion->query($sql);

$estados = [];
while ($row = $result->fetch_assoc()) {
    $estados[] = $row;
}

echo json_encode($estados);
?>
