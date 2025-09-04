<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

$Nivel_idNivel = $_GET['Nivel_idNivel'] ?? null;

if (!$Nivel_idNivel) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Falta el id del nivel']);
    exit;
}

$sql = "SELECT * FROM clases WHERE Nivel_idNivel=? AND deletedAt IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $Nivel_idNivel);
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
