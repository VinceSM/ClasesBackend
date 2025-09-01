<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php'; 

try {
    $resultado = $conexion->query("SELECT * FROM niveles");

    $niveles = [];
    while ($fila = $resultado->fetch_assoc()) {
        $niveles[] = $fila;
    }

    echo json_encode($niveles);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error al obtener niveles",
        "detalle" => $e->getMessage()
    ]);
}
