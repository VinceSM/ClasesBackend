<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT idDeportes, nombre 
        FROM deportes 
        WHERE deletedAt IS NULL OR deletedAt IS NULL"; // por si usas soft delete

$result = $conexion->query($sql);

$deportes = [];
while ($row = $result->fetch_assoc()) {
    $deportes[] = $row;
}

echo json_encode($deportes);

$conexion->close();
?>
