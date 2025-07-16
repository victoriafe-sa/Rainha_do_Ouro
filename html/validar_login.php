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
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM tb_usuarios_login WHERE email = ? AND ativo = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

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
                    exit();
            }

            exit();
        }
    }

    echo "Usuário ou senha incorretos.";
} else {
    header("Location: login.php");
    exit();
}

?>
