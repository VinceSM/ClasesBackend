<?php
require_once __DIR__ . '/../admin/headerCors.php';  
require_once __DIR__ . '/../conexion.php';

// session_set_cookie_params([
//   'lifetime' => 0,
//   'path' => '/',
//   'domain' => 'miramarinmobiliario.com.ar',
//   'secure' => true,
//   'httponly' => true,
//   'samesite' => 'Lax'  // ✅ Más estable y aceptado
// ]);

session_start();

// 🔄 Limpiar variables de sesión
$_SESSION = [];

// 🔐 Destruir cookie de sesión si existe
// if (isset($_COOKIE[session_name()])) {
//     setcookie(session_name(), '', [
//         'expires' => time() - 3600,
//         'path' => '/',
//         'domain' => 'miramarinmobiliario.com.ar',
//         'secure' => true,
//         'httponly' => true,
//         'samesite' => 'None'
//     ]);
//     unset($_COOKIE[session_name()]);
// }

// 💥 Destruir sesión
session_destroy();

// ✅ Respuesta JSON
echo json_encode(['success' => true, 'message' => 'Sesión cerrada correctamente']);
exit;
?>
