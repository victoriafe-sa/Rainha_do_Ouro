<?php
// estoque_utils.php

// Conexão com o banco
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_rainhadoouro';

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Função para atualizar ou inserir no estoque
function atualizarEstoque($conn, $id_produto, $nova_quantidade) {
    // Verifica se já existe estoque para o produto
    $sql_check = "SELECT COUNT(*) as total FROM tb_estoque WHERE tb_produtos_id_produtos = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id_produto);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $row = $result->fetch_assoc();
    $count = $row['total'];
    $stmt_check->close();

    if ($count > 0) {
        // Atualiza o estoque existente
        $sql_update = "UPDATE tb_estoque SET quantidade = ?, atualizado_em = NOW() WHERE tb_produtos_id_produtos = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ii", $nova_quantidade, $id_produto);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insere novo estoque com fornecedor padrão
        $fornecedor_id = 1; // Altere se necessário
        $sql_insert = "INSERT INTO tb_estoque (quantidade, atualizado_em, tb_fornecedores_id_fornecedores, tb_produtos_id_produtos) VALUES (?, NOW(), ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("iii", $nova_quantidade, $fornecedor_id, $id_produto);
        $stmt->execute();
        $stmt->close();
    }
}
?>
