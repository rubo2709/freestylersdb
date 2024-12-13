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

// Si todas las comprobaciones han tenido éxito ...
if ($hayRegistrosOk) {
    // Mostramos el formulario
    
?>

<form action="buscar-2.php" method="post">
<h2>Introduzca el nombre del registro a buscar</h2>
  <table>
    <tr>
      <td>Aka:</td>
      <td><input type="text" name="aka"  autofocus></td>
    </tr>
  </table>
  <p>
    <input type="submit" value="Buscar">
  </p>
</form>
<?php
}
?>
