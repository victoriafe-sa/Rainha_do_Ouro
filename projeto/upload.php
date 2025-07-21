<?php
require 'conexao.php';

if (isset($_POST['nome']) && isset($_FILES['imagem'])) {
    $nome = $_POST['nome'];
    $imagem = file_get_contents($_FILES['imagem']['tmp_name']);

    $stmt = $pdo->prepare("INSERT INTO imagens (nome, imagem) VALUES (:nome, :imagem)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':imagem', $imagem, PDO::PARAM_LOB);

    if ($stmt->execute()) {
        echo "Imagem enviada com sucesso!<br>";
        echo "<a href='../projeto/index.php'>Voltar</a>";
    } else {
        echo "Erro ao enviar imagem.";
    }
}
?>
