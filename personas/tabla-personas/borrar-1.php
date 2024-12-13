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

cabecera("Personas - Borrar 1");



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
    // Recuperamos todos los registros para mostrarlos en una <table>
    $consulta = "SELECT * FROM usuarios";

    $resultado = $pdo->query($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error en la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
    
?>
    <form action="borrar-2.php" method="post">
      <p>Marque el registro que quiera borrar:</p>
      <table class="conborde franjas">
        <thead>
          <tr>
            <th>Borrar</th>
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

                print "          <td class=\"centrado\"><input type=\"radio\" name=\"id\" value=\"$registro[id]\" checked></td>\n";
          
            
            print "          <td>$registro[nombre]</td>\n";
            print "          <td>$registro[apellidos]</td>\n";
            print "          <td>$registro[aka]</td>\n";
            print "          <td>$registro[ciudad]</td>\n";
            print "          <td>$registro[edad]</td>\n";
            print "          <td>$registro[telefono]</td>\n";
            print "        </tr>\n";
        }
        print "      </table>\n";
        print "\n";
        print "      <p>\n";
        print "        <input type=\"submit\" value=\"Borrar registro\" >\n";
        print "      </p>\n";
        print "    </form>\n";
    }

}
?>
