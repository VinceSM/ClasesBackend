<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php'; 

try {
    $resultado = $conexion->query("SELECT * FROM admin");

    $admin = [];
    while ($fila = $resultado->fetch_assoc()) {
        $admin[] = $fila;
    }

    echo json_encode($admin);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error al obtener admin",
        "detalle" => $e->getMessage()
    ]);
}
