<?php

include("../conectarbd.php");

$recid = filter_input(INPUT_POST, 'id');
$nome_completo = filter_input(INPUT_POST, 'nome_completo');
$data_nascimento = filter_input(INPUT_POST, 'data_nascimento');
$cpf = filter_input(INPUT_POST, 'cpf');
$rg = filter_input(INPUT_POST, 'rg');
$sexo = filter_input(INPUT_POST, 'sexo');
$estado_civil = filter_input(INPUT_POST, 'estado_civil');
$telefone = filter_input(INPUT_POST, 'telefone');
$email = filter_input(INPUT_POST, 'email');
$cep = filter_input(INPUT_POST, 'cep');
$rua = filter_input(INPUT_POST, 'rua');
$numero = filter_input(INPUT_POST, 'numero');
$bairro = filter_input(INPUT_POST, 'bairro');
$cidade = filter_input(INPUT_POST, 'cidade');
$estado = filter_input(INPUT_POST, 'estado');
$cargo = filter_input(INPUT_POST, 'cargo');
$horario_trabalho = filter_input(INPUT_POST, 'horario_trabalho');
$salario = filter_input(INPUT_POST, 'salario');
$tipo_contrato = filter_input(INPUT_POST, 'tipo_contrato');
$carteira_trabalho = filter_input(INPUT_POST, 'carteira_trabalho');
$pis = filter_input(INPUT_POST, 'pis');
$status = filter_input(INPUT_POST, 'status');
$observacoes = filter_input(INPUT_POST, 'observacoes');
$tipo_funcionario = filter_input(INPUT_POST, 'tipo_funcionario'); // novo campo

// Preparar a query segura
$stmt = mysqli_prepare($conn, "UPDATE tb_funcionarios SET
    nome_completo = ?,
    data_nascimento = ?,
    cpf = ?,
    rg = ?,
    sexo = ?,
    estado_civil = ?,
    telefone = ?,
    email = ?,
    cep = ?,
    rua = ?,
    numero = ?,
    bairro = ?,
    cidade = ?,
    estado = ?,
    cargo = ?,
    horario_trabalho = ?,
    salario = ?,
    tipo_contrato = ?,
    carteira_trabalho = ?,
    pis = ?,
    status = ?,
    observacoes = ?,
    tipo_funcionario = ?
    WHERE id_funcionarios = ?");

mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssssi",
    $nome_completo,
    $data_nascimento,
    $cpf,
    $rg,
    $sexo,
    $estado_civil,
    $telefone,
    $email,
    $cep,
    $rua,
    $numero,  // string
    $bairro,
    $cidade,
    $estado,
    $cargo,
    $horario_trabalho,
    $salario,
    $tipo_contrato,
    $carteira_trabalho,
    $pis,
    $status,
    $observacoes,
    $tipo_funcionario,
    $recid // id inteiro
);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Dados alterados com sucesso!'); window.location = 'FormConsultarFuncionario.php';</script>";
} else {
    echo "Não foi possível alterar os dados no Banco de Dados: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
