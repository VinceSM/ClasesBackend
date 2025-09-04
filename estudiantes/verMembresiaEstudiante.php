<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $idEstudiante = intval($_GET["idEstudiante"]);

    $sql = "SELECT m.*
            FROM estudiantes e
            INNER JOIN membresias m ON e.Membresia_idMembresia = m.idMembresia
            WHERE e.idEstudiantes = ? AND m.deletedAt IS NULL";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idEstudiante);
    $stmt->execute();
    $result = $stmt->get_result();

    $membresia = $result->fetch_assoc();

    echo json_encode($membresia ?: []);
    
    $stmt->close();
}
$conn->close();
?>
