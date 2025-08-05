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

    // Preparar consulta para buscar usuário na tabela tb_login
    $stmt = $conn->prepare("SELECT id_login, email, senha, tipo_usuario, status FROM tb_login WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        

        if ($usuario['status'] != 0) {
            echo "Usuário inativo. Entre em contato com o administrador.";
            exit;
        }

        // Verificar senha (supondo que senha foi salva com password_hash)
        if (password_verify($senha, $usuario['senha'])) {
            // Login OK - criar sessão
            $_SESSION['id_login'] = $usuario['id_login'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            // Redirecionar conforme tipo de usuário
            switch ($usuario['tipo_usuario']) {
                case 'adm':
                    header("Location: ../login_adm/dashboard_adm.php");
                    exit;
                case 'atendente':
                    header("Location: ../funcionario/dashboard_atend.php");
                    exit;
                case 'cabeleleira':
                    header("Location: ../funcionario/dashboard_cabel.php");
                    exit;
                default:
                    echo "Tipo de usuário desconhecido.";
                    exit;
            }
        } else {
            echo "Senha incorreta.";
            exit;
        }
    } else {
        echo "Usuário não encontrado.";
        exit;
    }
} else {
    echo "Método inválido.";
    exit;
}
