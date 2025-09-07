<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT * FROM profesores WHERE deletedAt IS NULL";
$result = $conexion->query($sql);

$profesores = [];
while ($row = $result->fetch_assoc()) {
    $profesores[] = $row;
}

echo json_encode($profesores);
?>
