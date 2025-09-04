<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipo = trim($_POST["tipo"]);
    $clasesPorMes = intval($_POST["clasesPorMes"]);
    $clasesPagadas = intval($_POST["clasesPagadas"]);
    $debe = isset($_POST["debe"]) ? intval($_POST["debe"]) : 0;
    $cantClasesDeuda = isset($_POST["cantClasesDeuda"]) ? intval($_POST["cantClasesDeuda"]) : 0;

    $sql = "INSERT INTO membresias (tipo, clasesPorMes, clasesPagadas, debe, cantClasesDeuda) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiii", $tipo, $clasesPorMes, $clasesPagadas, $debe, $cantClasesDeuda);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Membresía creada correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al crear membresía"]);
    }

    $stmt->close();
}
$conn->close();
?>
