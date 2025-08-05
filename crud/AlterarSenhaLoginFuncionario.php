<?php
header('Content-Type: application/json');
include_once '../conectarbd.php';

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['login'] ?? '');
$nova_senha = trim($data['nova_senha'] ?? '');

if (!$email || !$nova_senha) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos']);
    exit;
}

$senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

$sql = "UPDATE tb_login_gerencia SET senha = ? WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro na consulta']);
    exit;
}

$stmt->bind_param('ss', $senha_hash, $email);

if ($stmt->execute()) {
    echo json_encode(['sucesso' => true]);
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar senha']);
}

$stmt->close();
$conn->close();
?>
