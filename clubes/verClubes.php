<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT idClub, nombre, sede, direccion, ciudad, createdAt, updatedAt 
        FROM clubes 
        WHERE deletedAt IS NULL";
$result = $conn->query($sql);

$clubes = [];
while ($row = $result->fetch_assoc()) {
    $clubes[] = $row;
}

echo json_encode($clubes);

$conn->close();
?>
