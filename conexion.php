<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db = 'clases';

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}
?>