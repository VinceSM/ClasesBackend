<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$fecha = $data['fecha']; // formato YYYY-MM-DD

$sql = "SELECT c.idClases, c.nombre, c.maxestudiante, c.privada, 
               c.Horarios_idHorarios, c.Niveles_idNivel,
               h.fecha, h.hora_inicio, h.hora_fin,
               GROUP_CONCAT(chc.Canchas_idCanchas) AS canchas
        FROM clases c
        INNER JOIN horarios h ON c.Horarios_idHorarios = h.idHorarios
        LEFT JOIN clases_has_canchas chc ON c.idClases = chc.Clases_idClases
        WHERE DATE(h.fecha) = ?
          AND c.deletedAt IS NULL
        GROUP BY c.idClases";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $fecha);
$stmt->execute();
$result = $stmt->get_result();

$clases = [];
while ($row = $result->fetch_assoc()) {
    $row['canchas'] = $row['canchas'] ? explode(",", $row['canchas']) : [];
    $clases[] = $row;
}

echo json_encode($clases);
?>
