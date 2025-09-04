<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT * FROM estudiantes WHERE deletedAt IS NULL";
$result = $conn->query($sql);

$estudiantes = [];
while ($row = $result->fetch_assoc()) {
    $estudiantes[] = $row;
}

echo json_encode($estudiantes);
$conn->close();
?>
