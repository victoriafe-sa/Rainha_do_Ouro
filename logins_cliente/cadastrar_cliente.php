<?php

include("../testes/conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recebe e limpa dados
    $cpf = $_POST['cpf'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telefone = $_POST['telefone'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Novos campos:
    $cep = $_POST['cep'] ?? '';
    $rua = $_POST['rua'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $estado = $_POST['estado'] ?? '';

    // Verifica campos obrigatórios
    if (
        empty($cpf) || empty($nome) || empty($data_nascimento) || empty($email) ||
        empty($telefone) || empty($senha) || empty($cep) || empty($rua) || empty($numero) ||
        empty($bairro) || empty($cidade) || empty($estado)
    ) {
        header("Location: user_login.php?msg=campos_vazios");
        exit();
    }

    // Verifica se email já existe
    $sql_check = "SELECT id_clientes FROM tb_clientes WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    if (!$stmt_check) {
        header("Location: user_login.php?msg=erro");
        exit();
    }
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    if ($result_check->num_rows > 0) {
        $stmt_check->close();
        header("Location: user_login.php?msg=email_existe");
        exit();
    }
    $stmt_check->close();

    // Criptografa senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere cliente com todos os campos
    $sql = "INSERT INTO tb_clientes 
        (cpf, nome, telefone, data_nascimento, email, senha, cep, rua, numero, bairro, cidade, estado, ativo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        header("Location: user_login.php?msg=erro");
        exit();
    }
    $stmt->bind_param(
        "ssssssssssss",
        $cpf, $nome, $telefone, $data_nascimento, $email, $senha_hash,
        $cep, $rua, $numero, $bairro, $cidade, $estado
    );

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: user_login.php?msg=sucesso");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        header("Location: user_login.php?msg=erro");
        exit();
    }
} else {
    header("Location: user_login.php");
    exit();
}
?>
