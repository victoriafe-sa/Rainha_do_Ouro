<?php
session_start();
include("../conectarbd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $data_nascimento = trim($_POST['data_nascimento'] ?? '');
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    if (empty($email) || empty($telefone) || empty($data_nascimento) || empty($nova_senha) || empty($confirmar_senha)) {
        echo "<script>alert('Por favor, preencha todos os campos.'); window.history.back();</script>";
        exit;
    }

    if ($nova_senha !== $confirmar_senha) {
        echo "<script>alert('As senhas não conferem.'); window.history.back();</script>";
        exit;
    }

    // Para segurança, use hash:
    // $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
    // Se quiser manter sem hash (não recomendado):
    $senha_hash = $nova_senha;

    $sql = "UPDATE tb_clientes SET senha = ? WHERE email = ? AND telefone = ? AND data_nascimento = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>alert('Erro na preparação da consulta: " . $conn->error . "'); window.history.back();</script>";
        exit;
    }

    $stmt->bind_param("ssss", $senha_hash, $email, $telefone, $data_nascimento);
    $exec = $stmt->execute();

    if ($exec && $stmt->affected_rows > 0) {
        echo "<script>alert('Senha alterada com sucesso! Faça login com sua nova senha.'); window.location.href = '../html/user_login.php';</script>";
    } else {
        echo "<script>alert('Erro ao alterar a senha. Verifique os dados e tente novamente.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método inválido.";
}
?>
