<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Se espera que el nivel venga por GET: ?Nivel_idNivel=1
if (!isset($_GET['Nivel_idNivel'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Nivel no especificado']);
    exit;
}

$Nivel_idNivel = $_GET['Nivel_idNivel'];

$sql = "SELECT * FROM estudiantes WHERE Nivel_idNivel=? AND deletedAt IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $Nivel_idNivel);
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
