<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT * FROM niveles WHERE deletedAt IS NULL";
$result = $conexion->query($sql);

$niveles = [];
while ($row = $result->fetch_assoc()) {
    $niveles[] = $row;
}

echo json_encode($niveles);
?>
