<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idClase = $_GET['idClase'] ?? null;

if (!$idClase) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Falta el id de la clase']);
    exit;
}

$sql = "
SELECT e.*
FROM estudiantes e
JOIN clases_has_estudiantes che ON e.idEstudiantes = che.Estudiantes_idEstudiantes
WHERE che.Clases_idClases=? AND e.deletedAt IS NULL
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idClase);
$stmt->execute();
$result = $stmt->get_result();

$estudiantes = [];
while ($row = $result->fetch_assoc()) {
    $estudiantes[] = $row;
}

echo json_encode($estudiantes);
$stmt->close();
$conn->close();
?>
