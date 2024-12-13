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

cabecera("Personas - Añadir 1");

    // Mostramos el formulario
?>
<form action="insertar-2.php" method="post">
  <p>Escriba los datos del nuevo registro:</p>

  <table>
    <tr>
      <td>Nombre:</td>
      <td><input type="text" name="nombre" autofocus></td>
    </tr>
    <tr>
      <td>Apellidos:</td>
      <td><input type="text" name="apellidos"></td>
    </tr>
    <tr>
      <td>Aka:</td>
      <td><input type="text" name="aka"></td>
    </tr>
    <tr>
      <td>Ciudad:</td>
      <td><input type="text" name="ciudad"></td>
    </tr>
    <tr>
      <td>Edad:</td>
      <td><input type="number" name="edad"></td>
    </tr>
    <tr>
      <td>Teléfono:</td>
      <td><input type="text" name="telefono"></td>
    </tr>
    <tr>
  </table>
  <p>
    <input type="submit" value="Añadir">
    <input type="reset" value="Reiniciar formulario">
  </p>
</form>
<?php


?>
