<?php
session_start();
include("../conectarbd.php"); // Ajuste o caminho conforme sua estrutura

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        echo "Por favor, preencha e-mail e senha.";
        exit;
    }

    $sql = "SELECT id_clientes, email, senha, ativo FROM tb_clientes WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $cliente = $resultado->fetch_assoc();

        if ($cliente['ativo'] != 1) {
            echo "Conta inativa. Entre em contato com o salão.";
            exit;
        }

        // Comparar senha simples (texto puro)
        if ($senha === $cliente['senha']) {
            $_SESSION['id_cliente'] = $cliente['id_clientes'];
            $_SESSION['email_cliente'] = $cliente['email'];

            header("Location: ../html/pagina_inicial.html");
            exit;
        } else {
            echo "<script>alert('Senha incorreta.'); window.location.href = '../html/user_login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Usuário não encontrado.'); window.location.href = '../html/user_login.php';</script>";
        exit;
    }
} else {
    echo "Método inválido.";
    exit;
}
?>