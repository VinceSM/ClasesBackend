<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idNivel = $_GET['nivel'] ?? null;

if (!$idNivel) {
    echo json_encode(["success" => false, "message" => "Falta el id del nivel"]);
    exit;
}

$sql = "SELECT e.idEstudiantes, e.nombre, e.apellido, e.celular, e.edad, e.dni, e.nacimiento,
               e.Nivel_idNivel, n.tipo AS nivel,
               e.Membresia_idMembresia, m.tipo AS membresia
        FROM estudiantes e
        LEFT JOIN niveles n ON e.Nivel_idNivel = n.idNivel
        LEFT JOIN membresias m ON e.Membresia_idMembresia = m.idMembresia
        WHERE e.Nivel_idNivel = ? AND e.deletedAt IS NULL";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idNivel);
$stmt->execute();
$result = $stmt->get_result();

$estudiantes = [];
while ($row = $result->fetch_assoc()) {
    $estudiantes[] = $row;
}

echo json_encode($estudiantes);
?>
