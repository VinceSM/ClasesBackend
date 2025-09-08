<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sede = $_GET['sede'] ?? null;

if ($sede === null) {
    echo json_encode(["error" => "Sede requerida"]);
    exit;
}

$sql = "SELECT idClub, nombre, sede, direccion, ciudad 
        FROM clubes 
        WHERE sede = ? AND deletedAt IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sede);
$stmt->execute();
$result = $stmt->get_result();

$clubes = [];
while ($row = $result->fetch_assoc()) {
    $clubes[] = $row;
}

echo json_encode($clubes);

$stmt->close();
$conn->close();
?>
