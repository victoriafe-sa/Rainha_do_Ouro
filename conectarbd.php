<?php
$servidor = "localhost";
$dbusuario = "root";
$dbsenha = "";
$dbname = "db_rainhadoouro";
$conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
if (!$conn) {
    error_log("Connection failed: " . mysqli_connect_error(), 0);
    die("Erro interno no servidor. Tente novamente mais tarde.");
}
?>


