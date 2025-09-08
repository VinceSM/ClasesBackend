<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$ciudad = $_GET['ciudad'] ?? null;

if (!$ciudad) {
    echo json_encode(["error" => "Ciudad requerida"]);
    exit;
}

$sql = "SELECT idClub, nombre, sede, direccion, ciudad 
        FROM clubes 
        WHERE ciudad = ? AND deletedAt IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ciudad);
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
