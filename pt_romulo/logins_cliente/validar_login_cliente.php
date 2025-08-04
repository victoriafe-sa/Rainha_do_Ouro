<?php
session_start();
include("../testes/conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        echo "Preencha todos os campos.";
        exit();
    }

    $sql = "SELECT id_clientes, nome, senha, ativo FROM tb_clientes WHERE email = ? AND ativo = 1 LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Erro ao preparar consulta: " . $conn->error;
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $cliente = $result->fetch_assoc();

        if (password_verify($senha, $cliente['senha'])) {
            $_SESSION['id_cliente'] = $cliente['id_clientes'];
            $_SESSION['nome_cliente'] = $cliente['nome'];

            // Redireciona para página inicial do cliente (pode ajustar conforme seu projeto)
            header("Location: /Rainha_do_Ouro/html/pagina_inicial.html");
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Email não encontrado ou conta inativa.";
    }
} else {
    header("Location: user_login.php");
    exit();
}
?>
