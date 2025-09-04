<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT h.*, e.estado 
        FROM horarios h
        INNER JOIN estados e ON h.Estados_idEstados = e.idEstados
        WHERE h.deletedAt IS NULL AND h.disponible = 1";

$result = $conn->query($sql);
$horarios = [];

while ($row = $result->fetch_assoc()) {
    $horarios[] = $row;
}

echo json_encode($horarios);
$conn->close();
?>
