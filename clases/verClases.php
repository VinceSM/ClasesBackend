<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT c.idClases, c.nombre, c.maxestudiante, c.privada, 
               c.Horarios_idHorarios, c.Niveles_idNivel,
               GROUP_CONCAT(chc.Canchas_idCanchas) AS canchas
        FROM clases c
        LEFT JOIN clases_has_canchas chc ON c.idClases = chc.Clases_idClases
        WHERE c.deletedAt IS NULL
        GROUP BY c.idClases";

$result = $conexion->query($sql);

$clases = [];
while ($row = $result->fetch_assoc()) {
    $row['canchas'] = $row['canchas'] ? explode(",", $row['canchas']) : [];
    $clases[] = $row;
}

echo json_encode($clases);
?>
