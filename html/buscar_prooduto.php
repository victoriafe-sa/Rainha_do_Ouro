<?php
// Conexão com o banco de dados
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_rainhadoouro';

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Função para atualizar estoque e data de atualização do produto
function atualizarEstoque($conn, $id_produto, $nova_quantidade) {
    // Verifica se existe estoque para o produto
    $sql_check = "SELECT COUNT(*) AS total FROM tb_estoque WHERE tb_produtos_id_produtos = ?";
    $stmt_check = $conn->prepare($sql_check);
    if (!$stmt_check) {
        die("Erro na preparação do SELECT: " . $conn->error);
    }

    $stmt_check->bind_param("i", $id_produto);
    $stmt_check->execute();

    // Usa get_result para obter resultado como array associativo
    $resultado = $stmt_check->get_result();
    $row = $resultado->fetch_assoc();
    $count = $row['total'];
    $stmt_check->close();

    if ($count > 0) {
        // Atualiza estoque existente
        $sql_update = "UPDATE tb_estoque SET quantidade = ?, atualizado_em = NOW() WHERE tb_produtos_id_produtos = ?";
        $stmt = $conn->prepare($sql_update);
        if (!$stmt) {
            die("Erro na preparação do UPDATE: " . $conn->error);
        }

        $stmt->bind_param("ii", $nova_quantidade, $id_produto);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insere novo registro de estoque
        $sql_insert = "INSERT INTO tb_estoque (tb_produtos_id_produtos, quantidade, atualizado_em) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql_insert);
        if (!$stmt) {
            die("Erro na preparação do INSERT: " . $conn->error);
        }

        $stmt->bind_param("ii", $id_produto, $nova_quantidade);
        $stmt->execute();
        $stmt->close();
    }
}
// Exemplo de uso da função (você pode remover ou adaptar isso depois)
$id_produto = 1;
$nova_quantidade = 15;
atualizarEstoque($conn, $id_produto, $nova_quantidade);

$conn->close();
?>
