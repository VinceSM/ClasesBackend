<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT c.idCancha, c.cancha, c.indoor, d.nombre AS deporte
        FROM canchas c
        JOIN deportes d ON c.Deportes_idDeportes = d.idDeportes
        WHERE c.deletedAt IS NULL OR c.deletedAt IS NULL"; // por si usas soft delete

$result = $conexion->query($sql);

$canchas = [];
while ($row = $result->fetch_assoc()) {
    $row['indoor'] = $row['indoor'] ? true : false; // convertir a boolean
    $canchas[] = $row;
}

echo json_encode($canchas);

$conexion->close();
?>
