<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../html/user_login.php");
    exit;
}

include("../conectarbd.php");

$id_cliente = $_SESSION['id_cliente'];
$id_agendamento = $_POST['id_agendamento'] ?? null;

if (!$id_agendamento) {
    header("Location: ../html/perfil_usuario.php");
    exit;
}

// Verifica se o agendamento pertence ao cliente
$stmt = $conn->prepare("SELECT id_agendamentos FROM tb_agendamentos WHERE id_agendamentos = ? AND tb_clientes_id_clientes = ?");
$stmt->bind_param("ii", $id_agendamento, $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../html/perfil_usuario.php");
    exit;
}

// Atualiza status do agendamento para 'cancelado'
$stmtUpdate = $conn->prepare("UPDATE tb_agendamentos SET status = 'cancelado' WHERE id_agendamentos = ?");
$stmtUpdate->bind_param("i", $id_agendamento);
$stmtUpdate->execute();

header("Location: ../html/perfil_usuario.php#agendamentos");
exit;


?>
