<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["idHorarios"]);
    $fecha = $_POST["fecha"];
    $dia = $_POST["dia"];
    $inicio = $_POST["inicio"];
    $fin = $_POST["fin"];
    $disponible = isset($_POST["disponible"]) ? intval($_POST["disponible"]) : 0;
    $estadoId = intval($_POST["Estados_idEstados"]);

    $sql = "UPDATE horarios 
            SET fecha = ?, dia = ?, inicio = ?, fin = ?, disponible = ?, Estados_idEstados = ?, updatedAt = NOW() 
            WHERE idHorarios = ? AND deletedAt IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiii", $fecha, $dia, $inicio, $fin, $disponible, $estadoId, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Horario actualizado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar horario"]);
    }

    $stmt->close();
}
$conn->close();
?>
