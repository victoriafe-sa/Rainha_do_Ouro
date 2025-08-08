<?php
session_start();
include("../conectarbd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $data_nascimento = trim($_POST['data_nascimento'] ?? '');

    if (empty($email) || empty($telefone) || empty($data_nascimento)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    $sql = "SELECT id_clientes FROM tb_clientes WHERE email = ? AND telefone = ? AND data_nascimento = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit;
    }

    $stmt->bind_param("sss", $email, $telefone, $data_nascimento);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        echo "ok"; // Cliente válido
    } else {
        echo "Dados não conferem. Verifique e tente novamente.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método inválido.";
}
?>
