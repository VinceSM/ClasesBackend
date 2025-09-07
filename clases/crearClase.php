<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$nombre = $data['nombre'];
$maxestudiante = $data['maxestudiante'] ?? null;
$privada = $data['privada'];
$horarioId = $data['Horarios_idHorarios'];
$nivelId = $data['Niveles_idNivel'];
$canchas = $data['canchas']; // array de idCanchas

try {
    $conexion->begin_transaction();

    $stmt = $conexion->prepare("INSERT INTO clases (nombre, maxestudiante, privada, Horarios_idHorarios, Niveles_idNivel) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siiii", $nombre, $maxestudiante, $privada, $horarioId, $nivelId);
    $stmt->execute();
    $idClase = $stmt->insert_id;

    // Relación con canchas
    $stmtRel = $conexion->prepare("INSERT INTO clases_has_canchas (Clases_idClases, Canchas_idCanchas) VALUES (?, ?)");
    foreach ($canchas as $idCancha) {
        $stmtRel->bind_param("ii", $idClase, $idCancha);
        $stmtRel->execute();
    }

    $conexion->commit();
    echo json_encode(["success" => true, "message" => "Clase creada correctamente"]);
} catch (Exception $e) {
    $conexion->rollback();
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
