<?php
// Establecer la zona horaria a CDMX
date_default_timezone_set('America/Mexico_City');

// Nombre del archivo para almacenar los datos
$file = 'APPDATA.json';

// Leer el archivo si existe, o inicializar con valores por defecto
if (file_exists($file)) {
    $appData = json_decode(file_get_contents($file), true);
} else {
    $appData = [
        "DutyCycle" => 1,
        "voltaje" => 1.55,
        "first_request_at" => null,
        "last_request_at" => null
    ];
}

// Verificar si se recibió el parámetro 'new=1'
if (isset($_GET['new']) && $_GET['new'] == '1') {
    // Reiniciar las fechas
    $appData['first_request_at'] = date('Y-m-d H:i:s');
    $appData['last_request_at'] = date('Y-m-d H:i:s');
}

// Inicializar las fechas si aún no están definidas
if ($appData['first_request_at'] === null) {
    $appData['first_request_at'] = date('Y-m-d H:i:s');
}
$appData['last_request_at'] = date('Y-m-d H:i:s');

// Guardar los datos actualizados
file_put_contents($file, json_encode($appData));

// Responder únicamente con el valor de DutyCycle
header('Content-Type: application/json');
echo json_encode(["DutyCycle" => $appData['DutyCycle']]);
