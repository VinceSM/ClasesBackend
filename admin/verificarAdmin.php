<?php
session_start();

// Validar método permitido si lo definís por parámetro
if (isset($metodoEsperado) && $_SERVER['REQUEST_METHOD'] !== $metodoEsperado) {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Validar sesión de admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}
