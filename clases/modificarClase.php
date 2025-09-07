<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['idClases'];
$nombre = $data['nombre'];
$maxestudiante = $data['maxestudiante'] ?? null;
$privada = $data['privada'];
$horarioId = $data['Horarios_idHorarios'];
$nivelId = $data['Niveles_idNivel'];
$canchas = $data['canchas'];

try {
    $conexion->begin_transaction();

    $stmt = $conexion->prepare("UPDATE clases SET nombre=?, maxestudiante=?, privada=?, Horarios_idHorarios=?, Niveles_idNivel=?, updatedAt=NOW() WHERE idClases=?");
    $stmt->bind_param("siiiii", $nombre, $maxestudiante, $privada, $horarioId, $nivelId, $id);
    $stmt->execute();

    // Borrar relaciones anteriores
    $conexion->query("DELETE FROM clases_has_canchas WHERE Clases_idClases=$id");

    // Insertar nuevas relaciones
    $stmtRel = $conexion->prepare("INSERT INTO clases_has_canchas (Clases_idClases, Canchas_idCanchas) VALUES (?, ?)");
    foreach ($canchas as $idCancha) {
        $stmtRel->bind_param("ii", $id, $idCancha);
        $stmtRel->execute();
    }

    $conexion->commit();
    echo json_encode(["success" => true, "message" => "Clase modificada correctamente"]);
} catch (Exception $e) {
    $conexion->rollback();
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
