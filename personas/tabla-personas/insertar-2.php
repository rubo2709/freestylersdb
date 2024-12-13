<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   https://www.gnu.org/licenses/agpl-3.0.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("Personas - Añadir 2");

$nombre    = recoge("nombre");
$apellidos = recoge("apellidos");
$aka = recoge("aka");
$ciudad = recoge("ciudad");
$edad = recoge("edad");
$telefono  = recoge("telefono");

// Comprobamos si algún campo está vacío
$errores = [];

if ($nombre == "") {
    $errores[] = "nombre";
}
if ($apellidos == "") {
    $errores[] = "apellidos";
}
if ($aka == "") {
    $errores[] = "aka";
}
if ($ciudad == "") {
    $errores[] = "ciudad";
}
if ($edad == "") {
    $errores[] = "edad";
}
if ($telefono == "") {
    $errores[] = "telefono";
}

// Si hay campos vacíos, mostramos el mensaje de error
if (!empty($errores)) {
    print "    <p class=\"aviso\">No has rellenado todos los campos.</p>\n";
} else {
    // Comprobamos que no se intenta crear un registro idéntico a uno que ya existe
    $registroDistintoOk = false;

    $consulta = "SELECT COUNT(*) FROM usuarios
                 WHERE nombre = :nombre
                 AND apellidos = :apellidos
                 AND aka = :aka
                 AND ciudad = :ciudad
                 AND edad = :edad
                 AND telefono = :telefono";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":aka" => $aka, ":ciudad" => $ciudad, ":edad" => $edad, ":telefono" => $telefono])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif ($resultado->fetchColumn() > 0) {
        print "    <p class=\"aviso\">El registro ya existe.</p>\n";
    } else {
        $registroDistintoOk = true;
    }

    // Si todas las comprobaciones han tenido éxito ...
    if ($registroDistintoOk) {
        // Insertamos el registro en la tabla
        $consulta = "INSERT INTO usuarios
                     (nombre, apellidos, aka, ciudad, edad, telefono)
                     VALUES (:nombre, :apellidos, :aka, :ciudad, :edad, :telefono)"; // Se eliminó la coma extra

        $resultado = $pdo->prepare($consulta);
        if (!$resultado) {
            print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
        } elseif (!$resultado->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":aka" => $aka, ":ciudad" => $ciudad, ":edad" => $edad, ":telefono" => $telefono])) {
            print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
        } else {
            print "    <p>Registro creado correctamente.</p>\n";

            // Incrementar el contador de registros creados
            if (!isset($_SESSION["registros_creados"])) {
                $_SESSION["registros_creados"] = 0; // Inicializar si no existe
            }
            $_SESSION["registros_creados"]++;
        }
    }
}
?>
