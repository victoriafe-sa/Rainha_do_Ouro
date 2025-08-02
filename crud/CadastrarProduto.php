<?php
include_once "../conectarbd.php";

// Dados
$nome = $_POST["nome"];
$descricao = $_POST["descricao"];
$preco_venda = $_POST["preco_venda"];
$categoria = $_POST["categoria"];
$estoque = $_POST["estoque"];

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
    $nomeImagem = $_FILES['imagem']['name'];
    $extensao = strtolower(pathinfo($nomeImagem, PATHINFO_EXTENSION));

    if (!in_array($extensao, ['jpg', 'jpeg', 'png'])) {
        die("Formato de imagem inválido.");
    }

    $novoNomeImagem = uniqid() . "." . $extensao;
    $pasta = "../arquivo/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0755, true);
    }

    $caminhoImagem = $pasta . $novoNomeImagem;
    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
        $query = "INSERT INTO tb_produtos(nome, descricao, preco_venda, categoria, estoque, path, data_upload)
                  VALUES ('$nome', '$descricao', '$preco_venda', '$categoria', '$estoque', '$caminhoImagem', NOW())";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Produto adicionado com sucesso!'); window.location = '../html/dashboard.php';</script>";
        } else {
            echo "Erro ao salvar: " . mysqli_error($conn);
        }
    } else {
        die("Erro ao mover o arquivo.");
    }
} else {
    die("Erro ao enviar a imagem.");
}
?>
