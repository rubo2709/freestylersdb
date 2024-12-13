<?php
require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

// Recuperamos el valor de 'aka' de la URL
$aka = recoge("aka");

// Definir el nombre del archivo CSV
$nombreArchivo = "registros_busqueda_{$aka}_" . date("Y-m-d_H-i-s") . ".csv";

// Establecer las cabeceras para la descarga del CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
header('Pragma: no-cache');
header('Expires: 0');

// Abrir el flujo de salida para escribir el CSV
$output = fopen('php://output', 'w');

// Establecer la codificación UTF-8 para el archivo CSV
// Escribir la BOM de UTF-8 para garantizar que Excel lo lea correctamente en algunos casos
fwrite($output, "\xEF\xBB\xBF");

// Escribir los encabezados del CSV (nombres de las columnas)
fputcsv($output, ['ID', 'Nombre', 'Apellidos', 'Aka', 'Ciudad', 'Edad', 'Teléfono']);

// Consultar los registros de la base de datos con el valor de 'aka'
$consulta = "SELECT * FROM usuarios WHERE aka = :aka";
$resultado = $pdo->prepare($consulta);

if (!$resultado) {
    print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
} elseif (!$resultado->execute([":aka" => "$aka"])) {
    print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
} else {
    // Escribir los datos de los registros en el CSV
    // El ciclo aquí debe ser solo para cada fila de datos
    foreach ($resultado as $registro) {
        // Escribir una fila del CSV con los datos del registro
        // Cada campo de $registro es un valor para una columna en el CSV
        fputcsv($output, [
            $registro['id'], 
            $registro['nombre'], 
            $registro['apellidos'], 
            $registro['aka'], 
            $registro['ciudad'], 
            $registro['edad'], 
            $registro['telefono']
        ]);
    }
}

// Cerrar el flujo
fclose($output);
exit;
?>
