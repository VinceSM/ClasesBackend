<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT idCancha, cancha, indoor FROM canchas WHERE deletedAt IS NULL";
$result = $conexion->query($sql);

$canchas = [];
while ($row = $result->fetch_assoc()) {
    $row["indoor"] = $row["indoor"] == 1 ? true : false; // más legible en frontend
    $canchas[] = $row;
}

echo json_encode($canchas);

$conexion->close();
?>
