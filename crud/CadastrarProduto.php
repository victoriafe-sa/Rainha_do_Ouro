<?php
include_once "../conectarbd.php";

$nome = $_POST["nome"];
$descricao = $_POST["descricao"];
$preco_venda = $_POST["preco_venda"];
$categoria = $_POST["categoria"];

// Verifique se o arquivo foi enviado corretamente
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $imagem = addslashes(file_get_contents($_FILES['imagem']['tmp_name']));
} else {
    die("Erro ao enviar a imagem.");
}

$conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
mysqli_select_db($conn, 'db_rainhadoouro');

$sql = "INSERT INTO tb_produtos(nome, descricao, preco_venda, categoria, imagem)
        VALUES ('$nome', '$descricao', '$preco_venda', '$categoria', '$imagem')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Produto adicionado com sucesso!'); window.location = '../index.php';</script>";
} else {
    echo "Erro: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
