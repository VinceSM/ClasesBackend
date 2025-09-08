<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["idReserva"])) {
    echo json_encode(["success" => false, "message" => "ID de reserva obligatorio"]);
    exit;
}

$id = $data["idReserva"];
$torneo = $data["torneo"] ?? null;
$particular = $data["particular"] ?? null;
$idClase = $data["Clases_idClases"] ?? null;
$idClub = $data["Clubes_idClub"] ?? null;
$idEstado = $data["Estados_idEstados"] ?? null;

$query = "UPDATE reservas SET 
          torneo = COALESCE(?, torneo),
          particular = COALESCE(?, particular),
          Clases_idClases = COALESCE(?, Clases_idClases),
          Clubes_idClub = COALESCE(?, Clubes_idClub),
          Estados_idEstados = COALESCE(?, Estados_idEstados),
          updatedAt = NOW()
          WHERE idReserva = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiiiii", $torneo, $particular, $idClase, $idClub, $idEstado, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
