<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   https://www.gnu.org/licenses/agpl-3.0.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "comunes/biblioteca.php";
print "<link rel='stylesheet' type='text/css' href='pagina2.css'>";

conectaDb();
session_name("sesiondb");
session_start();

if (isset($_SESSION["conectado"])) {
    header("Location:tabla-personas/personas.php");
    exit;
}

$usuario  = recoge("usuario");
$password = recoge("password");

// Comprobamos los datos recibidos procedentes de un formulario
$usuarioOk  = true;
$passwordOk = true;

// Comprobamos que el usuario recibido con la contraseña recibida existe en la base de datos
$passwordCorrectoOk = false;

if ($usuarioOk && $passwordOk) {
    if ($usuario != "ruben" || $password!="123") {
        header("Location:login-1.php?aviso=Error: Nombre de usuario y/o contraseña incorrectos.");
    } else {
        $passwordCorrectoOk = true;
    }
}

// Si todas las comprobaciones han tenido éxito ...
if ($usuarioOk && $passwordOk && $passwordCorrectoOk) {
    // Creamos la variable de sesión "conectado"
    $_SESSION["conectado"] = true;

    header("Location:tabla-personas/personas.php");
}
