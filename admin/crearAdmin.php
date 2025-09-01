<?php
require_once "conexion.php"; // tu archivo de conexión

// Validar que los datos lleguen por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validaciones básicas
    if (empty($email) || empty($password)) {
        die("Error: Debes ingresar email y password.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: El email no es válido.");
    }

    // Hashear la contraseña con algoritmo seguro (bcrypt por defecto)
    $hashpass = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Preparar sentencia segura contra inyección SQL
        $stmt = $conn->prepare("INSERT INTO admin (email, hashpass, createdAt) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $email, $hashpass);

        if ($stmt->execute()) {
            echo "✅ Administrador creado correctamente.";
        } else {
            echo "❌ Error al crear administrador: " . $stmt->error;
        }

        $stmt->close();
    } catch (Exception $e) {
        echo "❌ Error en la base de datos: " . $e->getMessage();
    }

    $conn->close();
} else {
    echo "Acceso inválido.";
}
