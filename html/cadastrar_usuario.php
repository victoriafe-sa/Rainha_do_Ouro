<?php
include 'conexao.php';

$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha

// Verifica se o e-mail já está cadastrado
$sql_check = "SELECT * FROM tb_login_gerencia WHERE email = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo "Este email já está cadastrado. <a href='cadastro.php'>Tente outro</a>";
    exit();
}

// Insere no banco de dados
$sql = "INSERT INTO tb_login_gerencia (email, senha) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $senha);

if ($stmt->execute()) {
    echo "Usuário cadastrado com sucesso! <a href='login_adm.php'>Faça login</a>";
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}
?>
