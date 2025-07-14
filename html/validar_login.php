<?php
session_start();
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
}
?>
