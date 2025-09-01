<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

// Verificar que sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

// Leer JSON del body
$data = json_decode(file_get_contents("php://input"), true);

// Validar datos
if (!isset($data['email']) || !isset($data['password'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Email y password son requeridos"]);
    exit;
}

$email = trim($data['email']);
$password = $data['password'];

// Buscar admin por email
$sql = "SELECT id, email, hashpass FROM admin WHERE email = ? AND deleted_at IS NULL LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Credenciales inválidas"]);
    exit;
}

$admin = $result->fetch_assoc();

// Verificar password
if (!password_verify($password, $admin['hashpass'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "Credenciales inválidas"]);
    exit;
}

// Si todo está ok, devolver éxito
echo json_encode([
    "success" => true,
    "message" => "Login exitoso",
    "admin" => [
        "id" => $admin['id'],
        "email" => $admin['email']
    ]
]);
