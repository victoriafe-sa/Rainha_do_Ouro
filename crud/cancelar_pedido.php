<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../html/user_login.php");
    exit;
}

include("../conectarbd.php");

$id_cliente = $_SESSION['id_cliente']; // Corrigido aqui
$id_pedido = $_POST['id_pedido'] ?? null; // nome do campo POST singular

if (!$id_pedido) {
    header("Location: ../html/perfil_usuario.php");
    exit;
}

// Verifica se o pedido pertence ao cliente
$stmt = $conn->prepare("SELECT id_pedidos FROM tb_pedidos WHERE id_pedidos = ? AND id_cliente = ?"); // id_cliente singular, mesmo nome que no seu SELECT principal
$stmt->bind_param("ii", $id_pedido, $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../html/perfil_usuario.php");
    exit;
}

// Atualiza status do pedido para 'cancelado'
$stmtUpdate = $conn->prepare("UPDATE tb_pedidos SET status = 'cancelado' WHERE id_pedidos = ?");
$stmtUpdate->bind_param("i", $id_pedido);
$stmtUpdate->execute();

header("Location: ../html/perfil_usuario.php#pedidos");
exit;

?>
