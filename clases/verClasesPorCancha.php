<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$canchaId = $data['Canchas_idCanchas'];

$sql = "SELECT c.idClases, c.nombre, c.maxestudiante, c.privada,
               c.Horarios_idHorarios, c.Niveles_idNivel,
               GROUP_CONCAT(chc.Canchas_idCanchas) AS canchas
        FROM clases c
        INNER JOIN clases_has_canchas chc ON c.idClases = chc.Clases_idClases
        WHERE chc.Canchas_idCanchas = ?
          AND c.deletedAt IS NULL
        GROUP BY c.idClases";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $canchaId);
$stmt->execute();
$result = $stmt->get_result();

$clases = [];
while ($row = $result->fetch_assoc()) {
    $row['canchas'] = $row['canchas'] ? explode(",", $row['canchas']) : [];
    $clases[] = $row;
}

echo json_encode($clases);
?>
