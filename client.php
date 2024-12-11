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
        "voltaje" => 1.55
    ];
}

// Verificar si se recibió el parámetro 'dutycycle'
if (isset($_GET['dutycycle'])) {
    $appData['DutyCycle'] = $_GET['dutycycle']; // Actualizar el DutyCycle

    // Guardar los datos actualizados
    file_put_contents($file, json_encode($appData));

    // Responder con el valor actualizado
    header('Content-Type: application/json');
    echo json_encode(["DutyCycle" => $appData['DutyCycle']]);
} else {
    // Si no se recibió el parámetro, devolver un error
    header('Content-Type: application/json');
    echo json_encode(["error" => "El parámetro 'dutycycle' es requerido."]);
}
