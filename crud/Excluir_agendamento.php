<?php
session_start();
header('Content-Type: application/json');
include("../conectarbd.php");

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID do agendamento não informado']);
    exit;
}

$id = intval($_POST['id']);

// Validação de permissão para exclusão
if (isset($_SESSION['id_cliente'])) {
    $id_cliente = $_SESSION['id_cliente'];
    $verif = $conn->prepare("SELECT id_agendamentos FROM tb_agendamentos WHERE id_agendamentos = ? AND tb_clientes_id_clientes = ?");
    $verif->bind_param("ii", $id, $id_cliente);
    $verif->execute();
    $verif->store_result();
    if ($verif->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Permissão negada para excluir este agendamento']);
        exit;
    }
}

// Excluir agendamento
$stmt = $conn->prepare("DELETE FROM tb_agendamentos WHERE id_agendamentos = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Falha ao excluir agendamento']);
}
