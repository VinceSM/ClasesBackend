<?php
session_start();

// Función para verificar si el admin está logueado
function verificarAdmin($metodoEsperado = null) {
    // Validar método HTTP si se pasa como parámetro
    if ($metodoEsperado && $_SERVER['REQUEST_METHOD'] !== strtoupper($metodoEsperado)) {
        http_response_code(405); // Method Not Allowed
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
        exit;
    }

    // Validar sesión de admin
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        http_response_code(401); // Unauthorized
        echo json_encode([
            'success' => false,
            'message' => 'No autorizado'
        ]);
        exit;
    }

    // Si pasa las validaciones, devuelve true
    return true;
}
