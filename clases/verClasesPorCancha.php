<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idCancha = $_GET['idCancha'] ?? null;

if (!$idCancha) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Falta el id de la cancha']);
    exit;
}

$sql = "
SELECT DISTINCT c.*
FROM clases c
JOIN intervalos i ON c.idClases = i.Clases_idClases
WHERE i.Canchas_idCanchas = ? AND c.deletedAt IS NULL AND i.deletedAt IS NULL
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCancha);
$stmt->execute();
$result = $stmt->get_result();

$clases = [];
while ($row = $result->fetch_assoc()) {
    $clases[] = $row;
}

echo json_encode($clases);
$stmt->close();
$conn->close();
?>
