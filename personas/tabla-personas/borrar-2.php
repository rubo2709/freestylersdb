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

cabecera("Personas - Borrar 2");

$id = recoge("id");

// Comprobamos el dato recibido
$idOk = false;

if ($id == "") {
    print "    <p class=\"aviso\">No se ha seleccionado ningún registro.</p>\n";
} else {
    $idOk = true;
}

// Si hemos recibido un id de registro
if ($idOk) {
 
        // Comprobamos que el registro con el id recibido existe en la base de datos
        $registroEncontradoOk = false;

        $consulta = "SELECT COUNT(*) FROM usuarios
                     WHERE id = :indice";

        $resultado = $pdo->prepare($consulta);
        if (!$resultado) {
            print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
        } elseif (!$resultado->execute([":indice" => $id])) {
            print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
        } elseif ($resultado->fetchColumn() == 0) {
            print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
        } else {
            $registroEncontradoOk = true;    
        }

        // Si todas las comprobaciones han tenido éxito ...
        if ($registroEncontradoOk) {
            // Borramos el registro con el id recibido
            $consulta = "DELETE FROM usuarios
                         WHERE id = :indice";

            $resultado = $pdo->prepare($consulta);
            if (!$resultado) {
                print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
            } elseif (!$resultado->execute([":indice" => $id])) {
                print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
            } else {
                print "    <p>Registro borrado correctamente.</p>\n";

                // Incrementar el contador de registros borrados
                if (!isset($_SESSION["registros_borrados"])) {
                    $_SESSION["registros_borrados"] = 0; // Inicializar si no existe
                }
                $_SESSION["registros_borrados"]++;
            }
        }
    }

?>