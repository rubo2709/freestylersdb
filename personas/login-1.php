<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   https://www.gnu.org/licenses/agpl-3.0.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "comunes/biblioteca.php";
print "<link rel='stylesheet' type='text/css' href='pagina2.css'>";

session_name("sesiondb");
session_start();

if (isset($_SESSION["conectado"])) {
    header("Location:tabla-personas/personas.php");
    exit;
}

cabecera("Login 1");

$aviso = recoge("aviso");

if ($aviso != "") {
    print "    <p class=\"aviso\">$aviso</p>\n";
    print "\n";
}
?>
    <form action="login-2.php" method="post">
      <p>Escriba su nombre de usuario y contraseña:</p>

      <table>
        <tr>
          <td>Usuario:</td>
          <td><input type="text" name="usuario"  autofocus/></td>
        </tr>
        <tr>
          <td>Contraseña:</td>
          <td><input type="password" name="password" /></td>
        </tr>
      </table>

      <p>
        <input type="submit" value="Identificar">
        <input type="reset" value="Borrar">
      </p>
    </form>
<php 
pie();
?>
