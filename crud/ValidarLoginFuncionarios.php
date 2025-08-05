<?php
session_start();
include_once '../conectarbd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $tipo_usuario = trim($_POST['tipo_usuario'] ?? ''); // Caso você queira passar o tipo pelo formulário, ou deixar opcional

    if (empty($email) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!'); window.history.back();</script>";
        exit;
    }

    // Busca o usuário pelo email e ativo
    $sql = "SELECT lg.*, f.nome_completo 
            FROM tb_login_gerencia lg 
            JOIN tb_funcionarios f ON lg.id_funcionario = f.id_funcionarios 
            WHERE lg.email = ? AND lg.ativo = 1";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verifica se o tipo_usuario está definido e confere com o banco, se desejar validar tipo:
        if ($tipo_usuario && $tipo_usuario !== $usuario['tipo_usuario']) {
            echo "<script>alert('Tipo de usuário inválido!'); window.location.href = '../html/login_funcionario.php';</script>";
            exit;
        }

        // Verifica a senha com password_verify
        if (password_verify($senha, $usuario['senha'])) {
            // Login correto - inicia sessão
            $_SESSION['id_login'] = $usuario['id_login'];
            $_SESSION['id_funcionario'] = $usuario['id_funcionario'];
            $_SESSION['nome'] = $usuario['nome_completo'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            // Redireciona de acordo com o tipo
            switch ($usuario['tipo_usuario']) {
                case 'adm':
                    header("Location: ../html/dashboard_adm.php");
                    break;
                case 'recepcionista':
                    header("Location: ../html/dashboard_recepcionista.php");
                    break;
                case 'cabeleireira':
                        header("Location: ../html/dashboard_cabeleireira.php");
                        break;
                default:
                    echo "<script>alert('Tipo de usuário inválido!'); window.location.href = '../html/login_funcionario.php';</script>";
            }
            exit;
        } else {
            // Senha incorreta
            echo "<script>alert('Senha incorreta!'); window.location.href = '../html/login_funcionario.php';</script>";
            exit;
        }
    } else {
        // Email não encontrado
        echo "<script>alert('Login inválido! Verifique os dados.'); window.location.href = '../html/login_funcionario.php';</script>";
        exit;
    }
} else {
    // Se não for POST, redireciona ao login
    header("Location: ../html/login_funcionario.php");
    exit;
}