<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT * FROM clases WHERE deletedAt IS NULL";
$result = $conn->query($sql);

$clases = [];
while ($row = $result->fetch_assoc()) {
    $clases[] = $row;
}

echo json_encode($clases);
$conn->close();
?>
