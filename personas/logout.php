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

session_destroy();

header("Location:index.php");
