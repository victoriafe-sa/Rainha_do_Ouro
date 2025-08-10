<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../html/user_login.php");
    exit;
}

include("../conectarbd.php");

$recid = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$recnome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$rectelefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
$reccpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
$recdata_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING);
$recemail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$recsenha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$reccep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
$recrua = filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_STRING);
$recnumero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);
$recbairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
$reccidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
$recestado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);

if (!$recid) {
    die("ID inválido.");
}

// Prepared statement para evitar SQL injection
$stmt = $conn->prepare("UPDATE tb_clientes SET nome=?, telefone=?, cpf=?, data_nascimento=?, email=?, senha=?, cep=?, rua=?, numero=?, bairro=?, cidade=?, estado=? WHERE id_clientes=?");

$stmt->bind_param(
    "ssssssssssssi",
    $recnome,
    $rectelefone,
    $reccpf,
    $recdata_nascimento,
    $recemail,
    $recsenha,
    $reccep,
    $recrua,
    $recnumero,
    $recbairro,
    $reccidade,
    $recestado,
    $recid
);

if ($stmt->execute()) {
    echo "<script>alert('Dados alterados com sucesso!'); window.location = '../html/perfil_usuario.php';</script>";
} else {
    echo "Não foi possível alterar os dados no Banco de Dados: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
