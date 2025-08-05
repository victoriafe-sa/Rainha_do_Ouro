<?php
session_start();
include_once '../conectarbd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!'); window.location.href = '../html/login_adm.html';</script>";
        exit;
    }

    $sql = "SELECT lg.*, f.nome_completo 
            FROM tb_login_gerencia lg 
            JOIN tb_funcionarios f ON lg.id_funcionario = f.id_funcionarios 
            WHERE lg.email = ? AND lg.ativo = 1";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<script>alert('Erro ao preparar consulta.'); window.location.href = '../html/login_adm.html';</script>";
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
//aalterado
        if (password_verify($senha, $usuario['senha'])) {
            // Login correto
            $_SESSION['id_login'] = $usuario['id_login'];
            $_SESSION['id_funcionario'] = $usuario['id_funcionario'];
            $_SESSION['nome'] = $usuario['nome_completo'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            switch ($usuario['tipo_usuario']) {
                case 'adm':
                    header("Location: ../html/dashboard_adm.php");
                    exit;
                case 'recepcionista':
                case 'atendente':
                    header("Location: ../html/dashboard_recepcionista.php");
                    exit;
                case 'cabeleireira':
                    header("Location: ../html/dashboard_cabeleireira.php");
                    exit;
                default:
                    echo "<script>alert('Tipo de usuário inválido!'); window.location.href = '../html/login_adm.html';</script>";
                    exit;
            }
        } else {
            echo "<script>alert('Senha incorreta!'); window.location.href = '../html/login_adm.html';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Login inválido! Verifique os dados.'); window.location.href = '../html/login_adm.html';</script>";
        exit;
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../html/login_adm.html");
    exit;
}
