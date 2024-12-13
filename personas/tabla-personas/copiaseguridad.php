<?php
require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("Personas - Realizar copia de seguridad");

// Aquí va el botón para realizar la copia de seguridad
?>
<p>Realiza una copia de seguridad de todos los registros:</p>
<form action="copiaseguridad-2.php" method="post">
    <input type="submit" value="Realizar copia de seguridad">
</form>

<?php

?>
