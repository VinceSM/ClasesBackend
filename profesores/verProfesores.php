<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php'; 

try {
    $resultado = $conexion->query("SELECT * FROM profesores");

    $profesores = [];
    while ($fila = $resultado->fetch_assoc()) {
        $profesores[] = $fila;
    }

    echo json_encode($profesores);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error al obtener profesores",
        "detalle" => $e->getMessage()
    ]);
}
