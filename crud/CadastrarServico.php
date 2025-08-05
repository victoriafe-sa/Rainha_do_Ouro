<?php
include_once "../conectarbd.php";

// Dados do formulário
$nome = $_POST["nome"];
$descricao = $_POST["descricao"];
$duracao_min = $_POST["duracao_min"];
$preco = $_POST["preco"];

// Verifica se o arquivo foi enviado
if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
    $nomeArquivo = $_FILES['arquivo']['name'];
    $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

    if (!in_array($extensao, ['jpg', 'jpeg', 'png'])) {
        die("Tipo de arquivo não permitido.");
    }

    $novoNome = uniqid() . "." . $extensao;
    $pasta = "../arquivo/";

    // Cria a pasta se não existir
    if (!is_dir($pasta)) {
        mkdir($pasta, 0755, true);
    }

    $caminhoCompleto = $pasta . $novoNome;
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminhoCompleto)) {
        $query = "INSERT INTO tb_servicos(nome, descricao, duracao_min, preco,  path, data_upload)
                  VALUES ('$nome', '$descricao','$duracao_min', '$preco',  '$caminhoCompleto', NOW())";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Serviço adicionado com sucesso!'); window.location = '../html/dashboard_adm.php';</script>";
        } else {
            echo "Erro ao inserir: " . mysqli_error($conn);
        }
    } else {
        die("Erro ao mover o arquivo.");
    }
} else {
    die("Erro no envio da imagem.");
}
?>
