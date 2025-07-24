<?php
require '../conectarbd.php';

if (isset($_POST['nome']) && isset($_FILES['imagem'])) {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $imagem = file_get_contents($_FILES['imagem']['tmp_name']);
    $imagem = mysqli_real_escape_string($conn, $imagem);

    $sql = "INSERT INTO tb_imagens (nome, imagem) VALUES ('$nome', '$imagem')";

    if (mysqli_query($conn, $sql)) {
        echo "Imagem enviada com sucesso!<br>";
        echo "<a href='index.php'>Voltar</a>";
    } else {
        echo "Erro ao enviar imagem: " . mysqli_error($conn);
    }
}
?>
