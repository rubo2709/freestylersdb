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

cabecera("Personas - Listar");

// Comprobamos si la base de datos contiene registros
$consulta = "SELECT * FROM usuarios";

$resultado = $pdo->query($consulta);
if (!$resultado) {
    print "    <p class=\"aviso\">Error en la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
} elseif ($resultado->rowCount() == 0) {
    print "    <p class=\"aviso\">No se ha creado todavía ningún registro.</p>\n";
} else {
?>
    <p>Listado completo de registros:</p>

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
        <tbody>
<?php
        // Recorremos todos los registros para mostrarlos
        foreach ($resultado as $registro) {
            // Usamos htmlspecialchars para evitar inyección de HTML
            print "        <tr>\n";
            print "          <td>" . htmlspecialchars($registro['nombre']) . "</td>\n";
            print "          <td>" . htmlspecialchars($registro['apellidos']) . "</td>\n";
            print "          <td>" . htmlspecialchars($registro['aka']) . "</td>\n";
            print "          <td>" . htmlspecialchars($registro['ciudad']) . "</td>\n";
            print "          <td>" . htmlspecialchars($registro['edad']) . "</td>\n";
            print "          <td>" . htmlspecialchars($registro['telefono']) . "</td>\n";
            print "        </tr>\n";
        }
?>
        </tbody>
    </table>
<?php
    }


?>
