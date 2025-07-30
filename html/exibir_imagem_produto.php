<?php
include_once "../conectarbd.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
    mysqli_select_db($conn, 'db_rainhadoouro');

    $sql = "SELECT imagem FROM tb_produtos WHERE id_produtos = $id";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        header("Content-Type: image/jpeg"); // ou image/png, dependendo do tipo
        echo $row['imagem'];
    } else {
        echo "Imagem não encontrada.";
    }

    mysqli_close($conn);
} else {
    echo "ID inválido.";
}
?>
