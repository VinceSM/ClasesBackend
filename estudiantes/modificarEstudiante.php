<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$sql = "UPDATE estudiantes SET nombre=?, apellido=?, celular=?, dni=?, nacimiento=?, Nivel_idNivel=?, Membresia_idMembresia=?, updatedAt=CURRENT_TIMESTAMP 
        WHERE idEstudiantes=? AND deletedAt IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssi", 
    $data['nombre'], 
    $data['apellido'], 
    $data['celular'], 
    $data['dni'], 
    $data['nacimiento'], 
    $data['Nivel_idNivel'], 
    $data['Membresia_idMembresia'], 
    $data['idEstudiantes']
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$conn->close();
?>
