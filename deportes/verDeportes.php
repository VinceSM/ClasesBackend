<?php
require_once "conexion.php";

$sql = "SELECT nombre FROM deportes WHERE deletedAt IS NULL";
$result = $conn->query($sql);

$deportes = [];
while ($row = $result->fetch_assoc()) {
    $deportes[] = $row;
}

echo json_encode($deportes);

$conn->close();
?>
