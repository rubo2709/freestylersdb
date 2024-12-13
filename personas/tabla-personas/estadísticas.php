<?php
/**
 * @author    Bartolomé Sintes Marco
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

// Inicializar contadores en la sesión si no existen
if (!isset($_SESSION["registros_creados"])) {
    $_SESSION["registros_creados"] = 0;
}
if (!isset($_SESSION["registros_borrados"])) {
    $_SESSION["registros_borrados"] = 0;
}

$pdo = conectaDb();

cabecera("Personas - Buscar 1");

// Comprobamos si la base de datos contiene registros
$hayRegistrosOk = false;

$consulta = "SELECT COUNT(*) FROM usuarios";

$resultado = $pdo->query($consulta);
if (!$resultado) {
    print "    <p class=\"aviso\">Error en la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
} elseif ($resultado->fetchColumn() == 0) {
    print "    <p class=\"aviso\">No se ha creado todavía ningún registro.</p>\n";
} else {
    $hayRegistrosOk = true;
}

// Mostrar estadísticas de registros creados/borrados
print "<h2>Estadísticas de registros</h2>\n";
print "<p>Se han creado {$_SESSION["registros_creados"]} registros de freestylers.</p>\n";
print "<p>Se han borrado {$_SESSION["registros_borrados"]} registros de freestylers.</p>\n";




?>
