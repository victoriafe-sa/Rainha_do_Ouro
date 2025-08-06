<?php
// CadastrarFuncionario.php

include_once "../conectarbd.php"; // Seu arquivo com $conn já conectado

// Receber dados do POST
$nome_completo     = $_POST['nome_completo'];
$data_nascimento   = $_POST['data_nascimento'];
$cpf               = $_POST['cpf'];
$rg                = $_POST['rg'];
$sexo              = $_POST['sexo'];
$estado_civil      = $_POST['estado_civil'];
$telefone          = $_POST['telefone'];
$cep               = $_POST['cep'];
$rua               = $_POST['rua'];
$numero            = $_POST['numero'];
$bairro            = $_POST['bairro'];
$cidade            = $_POST['cidade'];
$estado            = $_POST['estado'];
$cargo             = $_POST['cargo'];
$horario_trabalho  = $_POST['horario_trabalho'];
$salario           = floatval($_POST['salario']);
$tipo_contrato     = $_POST['tipo_contrato'];
$carteira_trabalho = $_POST['carteira_trabalho'];
$pis               = $_POST['pis'];
$observacoes       = $_POST['observacoes'];
$tipo_funcionario  = $_POST['tipo_funcionario'];

// Gerar email automático: primeiro.ultimo@tipo.com
$nome_lower = strtolower($nome_completo);
$partes_nome = explode(' ', $nome_lower);
$primeiro_nome = $partes_nome[0];
$ultimo_nome = end($partes_nome);
$email_gerado = $primeiro_nome . '.' . $ultimo_nome . '@' . $tipo_funcionario . '.com';

// Gerar senha automática:
// padrão: primeiroNome + 4 números + caractere especial + 1 número + @ + tipo_funcionario
function gerarSenha($primeiroNome, $tipo) {
    $numeros = strval(rand(1000, 9999));
    $caracteresEspeciais = ['!', '#', '$', '%', '&', '*'];
    $caractEspecial = $caracteresEspeciais[array_rand($caracteresEspeciais)];
    $numeroFinal = rand(0,9);
    return $primeiroNome . $numeros . $caractEspecial . $numeroFinal . '@' . $tipo;
}
$senha_crua = gerarSenha($primeiro_nome, $tipo_funcionario);
$senha_hash = password_hash($senha_crua, PASSWORD_DEFAULT);

// Inserir na tabela tb_funcionarios
$sql_funcionario = "INSERT INTO tb_funcionarios 
    (nome_completo, data_nascimento, cpf, rg, sexo, estado_civil, telefone, cep, rua, numero, bairro, cidade, estado, cargo, horario_trabalho, salario, tipo_contrato, carteira_trabalho, pis, observacoes, tipo_funcionario)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql_funcionario);
$stmt->bind_param(
    "sssssssssssssssssssss",
    $nome_completo, $data_nascimento, $cpf, $rg, $sexo, $estado_civil, $telefone,
    $cep, $rua, $numero, $bairro, $cidade, $estado, $cargo, $horario_trabalho,
    $salario, $tipo_contrato, $carteira_trabalho, $pis, $observacoes, $tipo_funcionario
);

if ($stmt->execute()) {
    $id_funcionario = $stmt->insert_id;

    // Inserir na tabela de login (tb_login_gerencia)
    $sql_login = "INSERT INTO tb_login_gerencia (id_funcionario, email, senha, tipo_usuario, ativo) VALUES (?, ?, ?, ?, 1)";
    $stmt_login = $conn->prepare($sql_login);
    $stmt_login->bind_param("isss", $id_funcionario, $email_gerado, $senha_hash, $tipo_funcionario);
    if ($stmt_login->execute()) {
        // Sucesso: mostrar alert com email e senha gerada
        echo "<script>
            alert('Funcionário cadastrado com sucesso!\\n\\nLogin (email): $email_gerado\\nSenha: $senha_crua');
            window.location.href = '../html/dashboard_adm.php';
        </script>";
        exit();
    } else {
        echo "Erro ao cadastrar login: " . $stmt_login->error;
    }
} else {
    echo "Erro ao cadastrar funcionário: " . $stmt->error;
}

$stmt->close();
$stmt_login->close();
$conn->close();
?>
