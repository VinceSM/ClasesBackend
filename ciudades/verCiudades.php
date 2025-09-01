<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php'; 

try {
    $resultado = $conexion->query("SELECT * FROM ciudades");

    $ciudades = [];
    while ($fila = $resultado->fetch_assoc()) {
        $ciudades[] = $fila;
    }

    echo json_encode($ciudades);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error al obtener ciudades",
        "detalle" => $e->getMessage()
    ]);
}
