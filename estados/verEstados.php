<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php'; 

try {
    $resultado = $conexion->query("SELECT * FROM estados");

    $estados = [];
    while ($fila = $resultado->fetch_assoc()) {
        $estados[] = $fila;
    }

    echo json_encode($estados);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error al obtener estados",
        "detalle" => $e->getMessage()
    ]);
}
