<?php
header('Content-Type: application/json');
include_once '../conectarbd.php';

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['login'] ?? '');
$cpf = trim($data['cpf'] ?? '');

if (!$email || !$cpf) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos']);
    exit;
}

// Limpa CPF (só números)
$cpf_limpo = preg_replace('/[^0-9]/', '', $cpf);

// Consulta no banco:
// Faz join entre tb_login_gerencia e tb_funcionarios para verificar email e cpf juntos
$sql = "
    SELECT lg.email 
    FROM tb_login_gerencia lg
    INNER JOIN tb_funcionarios f ON lg.id_funcionario = f.id_funcionarios
    WHERE lg.email = ? AND REPLACE(REPLACE(REPLACE(f.cpf, '.', ''), '-', ''), ' ', '') = ?
    LIMIT 1
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro na consulta']);
    exit;
}

$stmt->bind_param('ss', $email, $cpf_limpo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    echo json_encode(['sucesso' => true]);
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Email ou CPF incorretos.']);
}

$stmt->close();
$conn->close();
?>
