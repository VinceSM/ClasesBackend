<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->idAdmin)) {
    $sql = "UPDATE admin SET ";
    $params = [];
    $types = "";

    if (!empty($data->email)) {
        $sql .= "email = ?, ";
        $params[] = $data->email;
        $types .= "s";
    }
    if (!empty($data->password)) {
        $sql .= "hashpass = ?, ";
        $params[] = password_hash($data->password, PASSWORD_BCRYPT);
        $types .= "s";
    }
    if (!empty($data->rol)) {
        $sql .= "rol = ?, ";
        $params[] = $data->rol;
        $types .= "s";
    }
    if (!empty($data->profesorId)) {
        $sql .= "Profesores_idProfesores = ?, ";
        $params[] = $data->profesorId;
        $types .= "i";
    }

    $sql .= "updatedAt = CURRENT_TIMESTAMP WHERE idAdmin = ?";
    $params[] = $data->idAdmin;
    $types .= "i";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Admin actualizado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar admin"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Falta idAdmin"]);
}

$conexion->close();
?>
