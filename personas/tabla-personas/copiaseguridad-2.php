<?php
require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

// Definir el nombre del archivo de texto
$nombreArchivo = "backup_personas_" . date("Y-m-d_H-i-s") . ".txt";

// Establecer las cabeceras adecuadas para la descarga del archivo de texto
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Pragma: no-cache');
header('Expires: 0');

// Abrir el flujo de salida para escribir el archivo de texto
$output = fopen('php://output', 'w');

// Escribir una cabecera descriptiva al principio del archivo
fwrite($output, "Copia de Seguridad - Registros de Freestylers\n");
fwrite($output, "Fecha: " . date("Y-m-d H:i:s") . "\n\n");
fwrite($output, "ID | Nombre | Apellidos | Aka | Ciudad | Edad | Teléfono\n");
fwrite($output, "---------------------------------------------------------\n");

// Consultar todos los registros
$consulta = "SELECT * FROM usuarios";
$resultado = $pdo->query($consulta);

// Verificamos si la consulta fue exitosa
if ($resultado) {
    // Escribir los datos de los registros en el archivo de texto
    foreach ($resultado as $registro) {
        $linea = implode(" | ", $registro) . "\n";
        fwrite($output, $linea);
    }
}

// Cerrar el flujo
fclose($output);
exit;
?>
