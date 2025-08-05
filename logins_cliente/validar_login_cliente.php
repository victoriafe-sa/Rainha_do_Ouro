<?php
session_start();
include("../conectarbd.php"); // ajuste o caminho conforme sua estrutura

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        header("Location: ../html/user_login.php?msg=campos_vazios");
        exit();
    }

    $sql = "SELECT id_clientes, nome, senha, ativo FROM tb_clientes WHERE email = ? AND ativo = 1 LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        // opcional: logar erro e redirecionar
        header("Location: ../html/user_login.php?msg=erro");
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

            header("Location: ../html/dashboard.php");
            exit();
        } else {
            header("Location: ../html/user_login.php?msg=erro");
            exit();
        }
    } else {
        header("Location: ../html/user_login.php?msg=erro");
        exit();
    }
} else {
    header("Location: ../html/user_login.php");
    exit();
}
