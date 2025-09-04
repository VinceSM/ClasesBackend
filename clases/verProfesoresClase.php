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
SELECT p.*
FROM profesores p
JOIN clases_has_profesores chp ON p.idProfesores = chp.Profesores_idProfesores
WHERE chp.Clases_idClases=? AND p.deletedAt IS NULL
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idClase);
$stmt->execute();
$result = $stmt->get_result();

$profesores = [];
while ($row = $result->fetch_assoc()) {
    $profesores[] = $row;
}

echo json_encode($profesores);
$stmt->close();
$conn->close();
?>
