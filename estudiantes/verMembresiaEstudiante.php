<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$idMembresia = $_GET['membresia'] ?? null;

if (!$idMembresia) {
    echo json_encode(["success" => false, "message" => "Falta el id de la membresía"]);
    exit;
}

$sql = "SELECT e.idEstudiantes, e.nombre, e.apellido, e.celular, e.edad, e.dni, e.nacimiento,
               e.Nivel_idNivel, n.tipo AS nivel,
               e.Membresia_idMembresia, m.tipo AS membresia
        FROM estudiantes e
        LEFT JOIN niveles n ON e.Nivel_idNivel = n.idNivel
        LEFT JOIN membresias m ON e.Membresia_idMembresia = m.idMembresia
        WHERE e.Membresia_idMembresia = ? AND e.deletedAt IS NULL";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idMembresia);
$stmt->execute();
$result = $stmt->get_result();

$estudiantes = [];
while ($row = $result->fetch_assoc()) {
    $estudiantes[] = $row;
}

echo json_encode($estudiantes);
?>
