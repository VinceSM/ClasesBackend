<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fecha = $_POST["fecha"];
    $dia = $_POST["dia"];
    $inicio = $_POST["inicio"];
    $fin = $_POST["fin"];
    $disponible = isset($_POST["disponible"]) ? intval($_POST["disponible"]) : 0;
    $estadoId = intval($_POST["Estados_idEstados"]);

    $sql = "INSERT INTO horarios (fecha, dia, inicio, fin, disponible, Estados_idEstados) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $fecha, $dia, $inicio, $fin, $disponible, $estadoId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Horario creado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al crear horario"]);
    }

    $stmt->close();
}
$conn->close();
?>
