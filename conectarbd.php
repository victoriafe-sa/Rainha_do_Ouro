<?php
$servidor = "localhost";
$dbusuario = "root";
$dbsenha = "";
$dbname = "db_rainhadoouro";
$conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
if (!$conn) {
    die("Conexão falhou: ". mysqli_connect_error());
}
?>


