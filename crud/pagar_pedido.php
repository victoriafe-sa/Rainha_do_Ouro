<?php
session_start();
include("../conectarbd.php");

if (!isset($_SESSION['id_cliente'])) {
    echo "Você precisa estar logado para finalizar o pagamento.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedido_id = intval($_POST['pedido_id']);
    $cliente_id = $_SESSION['id_cliente'];

    // Aqui você pode adicionar validações dos dados do cartão, etc (opcional/simulada)

    // Verificar se o pedido pertence ao usuário logado e está num status que permite pagamento
    $stmt = $conn->prepare("SELECT status FROM tb_pedidos WHERE id_pedidos = ? AND id_cliente = ?");
    $stmt->bind_param("ii", $pedido_id, $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Pedido não encontrado ou você não tem permissão para pagar este pedido.";
        exit;
    }

    $pedido = $result->fetch_assoc();

    if ($pedido['status'] === 'pago') {
        echo "Este pedido já está pago.";
        exit;
    }

    // Atualizar o status do pedido para 'pago'
    $update = $conn->prepare("UPDATE tb_pedidos SET status = 'pago' WHERE id_pedidos = ?");
    $update->bind_param("i", $pedido_id);

    if ($update->execute()) {
        // Redirecionar para uma página de sucesso ou mostrar mensagem
        header("Location: ../html/perfil_usuario.php#pedidos");
        exit;
    } else {
        echo "Erro ao atualizar o status do pedido.";
    }
} else {
    echo "Método inválido.";
}
?>
