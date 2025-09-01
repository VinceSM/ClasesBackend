<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';
session_start();

// Verificar que solo admins logueados puedan acceder
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Recibir datos
$idAdmin = isset($_POST['id']) ? intval($_POST['id']) : 0;
$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$password = isset($_POST['password']) ? trim($_POST['password']) : null;

if ($idAdmin <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID de admin inválido']);
    exit;
}

// Validar email si se proporciona
if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email inválido']);
    exit;
}

// Construir query dinámicamente según qué campos se van a modificar
$fields = [];
$params = [];
$types = '';

if ($email) {
    $fields[] = "email = ?";
    $params[] = $email;
    $types .= 's';
}

if ($password) {
    $fields[] = "hashpass = ?";
    $hashPass = password_hash($password, PASSWORD_DEFAULT);
    $params[] = $hashPass;
    $types .= 's';
}

if (empty($fields)) {
    echo json_encode(['success' => false, 'message' => 'No hay campos para modificar']);
    exit;
}

// Agregar ID para el WHERE
$params[] = $idAdmin;
$types .= 'i';

// Preparar la consulta
$query = "UPDATE admins SET " . implode(", ", $fields) . " WHERE id = ?";
$stmt = $conexion->prepare($query);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta']);
    exit;
}

// Vincular parámetros dinámicamente
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Admin modificado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al modificar admin: ' . $stmt->error]);
}

$stmt->close();
$conexion->close();
