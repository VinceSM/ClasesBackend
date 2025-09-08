<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["Clubes_idClub"], $data["Estados_idEstados"])) {
    echo json_encode(["success" => false, "message" => "Faltan datos obligatorios"]);
    exit;
}

$torneo = $data["torneo"] ?? 0;
$particular = $data["particular"] ?? 0;
$idClase = $data["Clases_idClases"] ?? null;
$idClub = $data["Clubes_idClub"];
$idEstado = $data["Estados_idEstados"];

$query = "INSERT INTO reservas (torneo, particular, Clases_idClases, Clubes_idClub, Estados_idEstados) 
          VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiiii", $torneo, $particular, $idClase, $idClub, $idEstado);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "idReserva" => $stmt->insert_id]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
