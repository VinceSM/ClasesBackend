<?php
require_once __DIR__ . '/../admin/headerCors.php';
require_once __DIR__ . '/../conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["idMembresia"]);
    $tipo = trim($_POST["tipo"]);
    $clasesPorMes = intval($_POST["clasesPorMes"]);
    $clasesPagadas = intval($_POST["clasesPagadas"]);
    $debe = isset($_POST["debe"]) ? intval($_POST["debe"]) : 0;
    $cantClasesDeuda = isset($_POST["cantClasesDeuda"]) ? intval($_POST["cantClasesDeuda"]) : 0;

    $sql = "UPDATE membresias 
            SET tipo = ?, clasesPorMes = ?, clasesPagadas = ?, debe = ?, cantClasesDeuda = ?, updatedAt = NOW()
            WHERE idMembresia = ? AND deletedAt IS NULL";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiiii", $tipo, $clasesPorMes, $clasesPagadas, $debe, $cantClasesDeuda, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Membresía actualizada correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar membresía"]);
    }

    $stmt->close();
}
$conn->close();
?>
