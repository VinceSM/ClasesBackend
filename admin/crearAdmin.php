<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

// Verificar que llegan los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if (!$email || !$password) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Faltan datos: email y password son requeridos'
        ]);
        exit;
    }

    // Hashear la contraseña
    $hashPass = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO admins (email, hashpass, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $email, $hashPass);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Admin registrado correctamente'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al registrar admin: ' . $stmt->error
            ]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Excepción: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido'
    ]);
}
