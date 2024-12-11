<?php
// Establecer la zona horaria a CDMX
date_default_timezone_set('America/Mexico_City');

// Nombre del archivo para almacenar los datos
$file = 'APPDATA.json';

// Leer los datos del archivo
if (file_exists($file)) {
    $appData = json_decode(file_get_contents($file), true);
} else {
    die("No se encontró el archivo APPDATA.json.");
}

// Verificar que las fechas estén definidas
if (isset($appData['first_request_at']) && isset($appData['last_request_at'])) {
    $firstRequest = strtotime($appData['first_request_at']);
    $lastRequest = strtotime($appData['last_request_at']);

    // Calcular la diferencia en horas, minutos y segundos
    $diff = $lastRequest - $firstRequest;
    $hours = floor($diff / 3600);
    $minutes = floor(($diff % 3600) / 60);
    $seconds = $diff % 60;

    $timeUsed = sprintf('%02d horas, %02d minutos, %02d segundos', $hours, $minutes, $seconds);
} else {
    $timeUsed = "Datos insuficientes para calcular el tiempo de uso.";
}

$voltaje = $appData['voltaje'] ?? "No definido";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado del Sistema</title>
</head>
<body>
    <h1>Estado del Sistema</h1>
    <p><strong>Voltaje actual:</strong> <?= $voltaje ?> V</p>
    <p><strong>Tiempo de uso:</strong> <?= $timeUsed ?></p>

    <form action="index.php" method="get">
        <button type="submit">Actualizar</button>
    </form>

    <form action="modificar.php" method="get">
        <button type="submit">Modificar</button>
    </form>
</body>
</html>
