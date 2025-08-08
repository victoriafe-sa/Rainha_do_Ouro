<?php
session_start();
include("../conectarbd.php");

// Para debugging local (opcional): descomente temporariamente
// ini_set('display_errors', 1); error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método inválido.";
    exit;
}

// Normaliza entradas
$email = strtolower(trim($_POST['email'] ?? ''));
$telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? ''); // só números
$data_nascimento = trim($_POST['data_nascimento'] ?? '');
$nova_senha = $_POST['nova_senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';

if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data_nascimento)) {
    [$dia, $mes, $ano] = explode('/', $data_nascimento);
    $data_nascimento = "$ano-$mes-$dia";
}

// Validações básicas
if (!$email || !$telefone || !$data_nascimento || !$nova_senha || !$confirmar_senha) {
    echo "<script>alert('Por favor, preencha todos os campos.'); window.history.back();</script>";
    exit;
}

if ($nova_senha !== $confirmar_senha) {
    echo "<script>alert('As senhas não conferem.'); window.history.back();</script>";
    exit;
}

// -- ATENÇÃO: se quiser usar hash, descomente a linha abaixo e ajuste validações.
// $senha_final = password_hash($nova_senha, PASSWORD_DEFAULT);
$senha_final = $nova_senha; // temporário, sem hash (conforme seu requisito atual)

// Tenta fazer UPDATE
$sql = "
    UPDATE tb_clientes
    SET senha = ?
    WHERE LOWER(TRIM(email)) = ?
      AND REPLACE(REPLACE(REPLACE(REPLACE(telefone, '(', ''), ')', ''), '-', ''), ' ', '') = ?
      AND DATE(data_nascimento) = ?
    LIMIT 1
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log('ALTERAR PREPARE ERRO: ' . $conn->error);
    echo "<script>alert('Erro interno. Tente novamente mais tarde.'); window.history.back();</script>";
    exit;
}

$stmt->bind_param("ssss", $senha_final, $email, $telefone, $data_nascimento);
$executou = $stmt->execute();

if ($executou && $stmt->affected_rows > 0) {
    $stmt->close();
    $conn->close();
    echo "<script>alert('Senha alterada com sucesso! Faça login com sua nova senha.'); window.location.href = '../html/user_login.php';</script>";
    exit;
}

// Se chegou aqui, ou não executou ou não afetou linhas.
// Vamos verificar se o usuário existe (mesmos critérios)
$stmt->close();

$sql2 = "
    SELECT senha
    FROM tb_clientes
    WHERE LOWER(TRIM(email)) = ?
      AND REPLACE(REPLACE(REPLACE(REPLACE(telefone, '(', ''), ')', ''), '-', ''), ' ', '') = ?
      AND DATE(data_nascimento) = ?
    LIMIT 1
";
$stmt2 = $conn->prepare($sql2);
if (!$stmt2) {
    error_log('SELECT PREPARE ERRO: ' . $conn->error);
    echo "<script>alert('Erro interno. Tente novamente mais tarde.'); window.history.back();</script>";
    exit;
}

$stmt2->bind_param("sss", $email, $telefone, $data_nascimento);
$stmt2->execute();
$res = $stmt2->get_result();

if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $senha_atual = $row['senha'] ?? '';

    // Se não está usando hash, pode comparar diretamente
    if ($senha_atual === $senha_final) {
        echo "<script>alert('A nova senha é igual à senha atual. Escolha uma senha diferente.'); window.history.back();</script>";
    } else {
        // Registro existe mas UPDATE não alterou — algo inesperado: log para análise
        error_log("ALERTAR_SENHA_FALHA: UPDATE não alterou (email={$email}, tel={$telefone}, data={$data_nascimento}).");
        echo "<script>alert('Erro ao alterar a senha. Tente novamente mais tarde.'); window.history.back();</script>";
    }
} else {
    // Usuário não encontrado com os dados informados
    echo "<script>alert('Dados não conferem. Verifique seu email, telefone e data de nascimento.'); window.history.back();</script>";
}

$stmt2->close();
$conn->close();
exit;
?>
