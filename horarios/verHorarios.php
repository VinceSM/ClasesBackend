<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$fecha = $_GET['fecha'] ?? null;
$dia = $_GET['dia'] ?? null;
$disponible = $_GET['disponible'] ?? null;

$sql = "SELECT h.idHorarios, h.fecha, h.dia, h.inicio, h.fin, h.disponible, e.estado
        FROM horarios h
        LEFT JOIN estados e ON h.Estados_idEstados = e.idEstados
        WHERE h.deletedAt IS NULL";

$params = [];
$types = "";

if ($fecha) {
    $sql .= " AND h.fecha = ?";
    $params[] = $fecha;
    $types .= "s";
}

if ($dia) {
    $sql .= " AND h.dia = ?";
    $params[] = $dia;
    $types .= "s";
}

if ($disponible !== null) {
    $sql .= " AND h.disponible = ?";
    $params[] = $disponible;
    $types .= "i";
}

$stmt = $conexion->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$horarios = [];
while ($row = $result->fetch_assoc()) {
    $horarios[] = $row;
}

echo json_encode($horarios);
?>
