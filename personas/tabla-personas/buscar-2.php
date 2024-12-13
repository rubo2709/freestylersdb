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

cabecera("Personas - Buscar 2");

$aka    = recoge("aka");

// Comprobamos los datos recibidos procedentes de un formulario
$akaOk    = false;
if ($aka == "") {
    print "<p class=\"aviso\">El a.k.a proporcionado está vacío</p>";
} else {
    $akaOk = true;
}

// Comprobamos si existen registros con las condiciones de búsqueda recibidas
$registrosEncontradosOk = false;

if ($akaOk) {
    $consulta = "SELECT COUNT(*) FROM usuarios WHERE aka = :aka;";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":aka" => "$aka"])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif ($resultado->fetchColumn() == 0) {
        print "    <p class=\"aviso\">No se han encontrado registros.</p>\n";
    } else {
        $registrosEncontradosOk = true;
    }
}

// Si todas las comprobaciones han tenido éxito ...
if ($akaOk && $registrosEncontradosOk) {
    // Seleccionamos todos los registros con las condiciones de búsqueda recibidas
    $consulta = "SELECT * FROM usuarios WHERE aka = :aka";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":aka" => "$aka"])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
?>

    <p>Registros encontrados:</p>

    <table class="conborde franjas">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Aka</th>
                <th>Ciudad</th>
                <th>Edad</th>
                <th>Teléfono</th>
            </tr>
        </thead>
<?php
        foreach ($resultado as $registro) {
            print "        <tr>\n";
            print "          <td>$registro[nombre]</td>\n";
            print "          <td>$registro[apellidos]</td>\n";
            print "          <td>$registro[aka]</td>\n";
            print "          <td>$registro[ciudad]</td>\n";
            print "          <td>$registro[edad]</td>\n";
            print "          <td>$registro[telefono]</td>\n";
            print "        </tr>\n";
        }
        print "      </table>\n";

        // Botón para exportar los resultados a CSV
        echo '<p><a href="exportar_buscar.php?aka=' . urlencode($aka) . '"><button>Exportar datos a CSV</button></a></p>';
    }
}


?>
