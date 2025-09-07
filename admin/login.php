<?php
session_start();
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password)) {
    $stmt = $conexion->prepare("SELECT idAdmin, email, hashpass, rol FROM admin WHERE email = ? AND deletedAt IS NULL LIMIT 1");
    $stmt->bind_param("s", $data->email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($data->password, $admin["hashpass"])) {
            // Guardamos datos en sesión
            $_SESSION["idAdmin"] = $admin["idAdmin"];
            $_SESSION["email"] = $admin["email"];
            $_SESSION["rol"] = $admin["rol"];

            echo json_encode([
                "success" => true,
                "message" => "Login exitoso",
                "user" => [
                    "idAdmin" => $admin["idAdmin"],
                    "email" => $admin["email"],
                    "rol" => $admin["rol"]
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Usuario no encontrado"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Faltan datos"]);
}

$conexion->close();
?>
