<?php
file_put_contents('debug_log.txt', file_get_contents('php://input'));

session_start();
header('Content-Type: application/json');

// Verifica se usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não logado']);
    exit;
}

// Recebe JSON POST
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Dados inválidos']);
    exit;
}

$userId = $_SESSION['id_cliente'];
$cep = filter_var($data['cep']);
$itens = $data['itens'] ?? [];

if (empty($itens)) {
    echo json_encode(['status' => 'error', 'message' => 'Carrinho vazio']);
    exit;
}

// Aqui você deve incluir sua conexão com o banco de dados
include('../conectarbd.php');
// Exemplo usando PDO
file_put_contents('debug_itens.log', print_r($itens, true));

try {
    $pdo = new PDO("mysql:host=localhost;dbname=db_rainhadoouro;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Inicia transação para garantir atomicidade
    $pdo->beginTransaction();

    // Calcula total
    $total = 0;
    foreach ($itens as $item) {
        $preco = $item['price'] ?? 0;
        $quantidade = $item['quantity'] ?? 1;
        $total += $preco * $quantidade;
    }

    // Insere pedido com total
    $stmt = $pdo->prepare("INSERT INTO tb_pedidos (id_cliente, cep, data_pedido, total) VALUES (?, ?, NOW(), ?)");
    $stmt->execute([$userId, $cep, $total]);

    $pedidoId = $pdo->lastInsertId();


    // 2. Insere os itens na tabela itens_pedido
    $stmtItem = $pdo->prepare("INSERT INTO tb_itens_pedido (id_pedidos, id_produtos, quantidade, preco_unit) VALUES (?, ?, ?, ?)");

    foreach ($itens as $item) {
        $idProduto = $item['id'] ?? null;
        $preco = $item['price'] ?? 0;
        $quantidade = $item['quantity'] ?? 1;

        $stmtItem->execute([$pedidoId, $idProduto, $quantidade, $preco]);
    }


    $pdo->commit();

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['status' => 'error', 'message' => 'Erro no banco: ' . $e->getMessage()]);
}
