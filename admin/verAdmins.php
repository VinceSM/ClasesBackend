<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$result = $conexion->query("SELECT a.idAdmin, a.email, a.rol, a.createdAt, a.updatedAt, p.nombre AS profesorNombre, p.apellido AS profesorApellido 
                            FROM admin a 
                            JOIN profesores p ON a.Profesores_idProfesores = p.idProfesores
                            WHERE a.deletedAt IS NULL");

$admins = [];
while ($row = $result->fetch_assoc()) {
    $admins[] = $row;
}

echo json_encode($admins);

$conexion->close();
?>
