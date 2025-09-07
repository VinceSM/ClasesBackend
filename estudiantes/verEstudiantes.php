<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$sql = "SELECT e.idEstudiantes, e.nombre, e.apellido, e.celular, e.edad, e.dni, e.nacimiento,
               e.Nivel_idNivel, n.nombre AS nivel,
               e.Membresia_idMembresia, m.nombre AS membresia
        FROM estudiantes e
        LEFT JOIN niveles n ON e.Nivel_idNivel = n.idNivel
        LEFT JOIN membresias m ON e.Membresia_idMembresia = m.idMembresia
        WHERE e.deletedAt IS NULL";

$result = $conexion->query($sql);

$estudiantes = [];
while ($row = $result->fetch_assoc()) {
    $estudiantes[] = $row;
}

echo json_encode($estudiantes);
?>
