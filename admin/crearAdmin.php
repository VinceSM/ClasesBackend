<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password) && !empty($data->rol) && !empty($data->profesorId)) {
    $hashpass = password_hash($data->password, PASSWORD_BCRYPT);

    $stmt = $conexion->prepare("INSERT INTO admin (email, hashpass, rol, Profesores_idProfesores) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $data->email, $hashpass, $data->rol, $data->profesorId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Admin creado correctamente", "idAdmin" => $stmt->insert_id]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al crear admin"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}

$conexion->close();
?>
