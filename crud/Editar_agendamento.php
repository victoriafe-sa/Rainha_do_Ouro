<?php
session_start();
header('Content-Type: application/json');
include("../conectarbd.php");

// Validação mínima (pode ampliar depois)
if (
    !isset($_POST['id_agendamento']) || 
    !isset($_POST['data']) || 
    !isset($_POST['horario']) || 
    !isset($_POST['status']) || 
    !isset($_POST['servico']) || 
    !isset($_POST['tipoServico'])
) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
    exit;
}

$id = intval($_POST['id_agendamento']);
$data = $_POST['data'];
$horario = $_POST['horario'];
$status = $_POST['status'];
$servico = $_POST['servico'];
$tipoServico = $_POST['tipoServico'];

// Opcional: garantir que o usuário tem permissão para editar este agendamento
// Exemplo: se for cliente, só pode editar seus próprios agendamentos
if (isset($_SESSION['id_cliente'])) {
    $id_cliente = $_SESSION['id_cliente'];
    // Verifica se o agendamento pertence ao cliente
    $verif = $conn->prepare("SELECT id_agendamentos FROM tb_agendamentos WHERE id_agendamentos = ? AND tb_clientes_id_clientes = ?");
    $verif->bind_param("ii", $id, $id_cliente);
    $verif->execute();
    $verif->store_result();
    if ($verif->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Permissão negada para editar este agendamento']);
        exit;
    }
}

// Atualiza dados no banco
$sql = "UPDATE tb_agendamentos SET data = ?, horario = ?, status = ?, servico = ?, tipoServico = ? WHERE id_agendamentos = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $data, $horario, $status, $servico, $tipoServico, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Falha ao atualizar agendamento']);
}
