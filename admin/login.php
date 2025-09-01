<?php
require_once __DIR__ . '/../admin/headerCors.php';  
require_once __DIR__ . '/../conexion.php';

// 🔒 Elimina cookies anteriores manualmente
// if (isset($_COOKIE['PHPSESSID'])) {
//     unset($_COOKIE['PHPSESSID']);
//     setcookie('PHPSESSID', '', [
//         'expires' => time() - 3600,
//         'path' => '/',
//         'domain' => 'miramarinmobiliario.com.ar',
//         'secure' => true,
//         'httponly' => true,
//         'samesite' => 'None'
//     ]);
// }

// 🔐 Configuración segura de la cookie de sesión
// session_set_cookie_params([
//   'lifetime' => 0,
//   'path' => '/',
//   'domain' => 'miramarinmobiliario.com.ar',
//   'secure' => true,
//   'httponly' => true,
//   'samesite' => 'Lax'  // ✅ Más estable y aceptado
// ]);

session_start();
header('Content-Type: application/json');

// ✅ Validar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// ⏱️ Control de intentos
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt'] = time();
}

if (time() - $_SESSION['last_attempt'] > 1800) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SESSION['login_attempts'] >= 5) {
    echo json_encode(['success' => false, 'message' => 'Demasiados intentos fallidos. Intenta de nuevo más tarde.']);
    exit;
}

// 🔍 Parsear y validar input
$rawData = file_get_contents("php://input");
$data = json_decode($rawData);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Datos no recibidos correctamente']);
    exit;
}

$email = filter_var($data->email ?? '', FILTER_SANITIZE_EMAIL);
$hashpass = $data->hashpass ?? '';

if (!$email || !$hashpass) {
    echo json_encode(['success' => false, 'message' => 'Faltan credenciales']);
    exit;
}

// 🔗 Verificar conexión
if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conexion->connect_error]);
    exit;
}

// 🔐 Buscar usuario
$sql = "SELECT * FROM admin WHERE email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if ($admin) {
    if (password_verify($hashpass, $admin['hashpass'])) {
        $_SESSION['login_attempts'] = 0;

        // Guardar sesión
        $_SESSION['admin_id'] = $admin['idAdmin'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['user'] = $admin['email'];
        $_SESSION['last_activity'] = time();

        session_regenerate_id(true);

        echo json_encode(['success' => true]);
        exit;
    } else {
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt'] = time();
        echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
        exit;
    }
} else {
    $_SESSION['login_attempts']++;
    $_SESSION['last_attempt'] = time();
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    exit;
}
?>
