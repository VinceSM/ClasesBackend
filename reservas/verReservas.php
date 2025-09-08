<?php
require_once __DIR__ . '/../headerCors.php';
require_once __DIR__ . '/../conexion.php';

$query = "SELECT r.idReserva, r.torneo, r.particular,
                 c.nombre AS club,
                 e.estado,
                 cl.nombre AS clase
          FROM reservas r
          INNER JOIN clubes c ON r.Clubes_idClub = c.idClub
          INNER JOIN estados e ON r.Estados_idEstados = e.idEstados
          LEFT JOIN clases cl ON r.Clases_idClases = cl.idClases";

$result = $conn->query($query);

$reservas = [];
while ($row = $result->fetch_assoc()) {
    $reservas[] = $row;
}

echo json_encode($reservas);

$conn->close();
?>
