<?php
/*session_start();
include 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM tb_login_gerencia WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    if (password_verify($senha, $user['senha'])) {
        $_SESSION['usuario'] = $user['email'];
        header("Location: dashboard_adm.php");
        exit();
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Email não encontrado.";
}*/

//Codigo novo para permissão de login cod antigo a cima//

session_start();
require 'conexao.php'; // este arquivo deve conectar ao banco `db_rainhadoouro`

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitiza os dados recebidos do formulário
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    // Verifica se os campos estão preenchidos
    if (empty($email) || empty($senha)) {
        echo "Preencha todos os campos.";
        exit();
    }

    // Busca o usuário pelo e-mail
    $sql = "SELECT * FROM tb_usuarios_login WHERE email = ? AND ativo = 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Erro na preparação da consulta.";
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se encontrou o usuário
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifica se a senha está correta
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario'] = $user['email'];
            $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
            $_SESSION['id_externo'] = $user['id_externo'];

            // Redireciona de acordo com o tipo de usuário
            switch ($user['tipo_usuario']) {
                case 'admin':
                    header("Location: dashboard_adm.php");
                    break;
                case 'secretaria':
                    header("Location: dashboard_secretaria.php");
                    break;
                case 'cliente':
                    header("Location: dashboard_cliente.php");
                    break;
                case 'cabeleireiro':
                    header("Location: dashboard_cabeleireiro.php");
                    break;
                default:
                    echo "Tipo de usuário inválido.";
            }
            exit();
        }
    }

    // Se não encontrar ou a senha estiver incorreta
    echo "Usuário ou senha incorretos.";
} else {
    // Se tentar acessar diretamente, redireciona para login
    header("Location: login.php");
    exit();
}
?>

