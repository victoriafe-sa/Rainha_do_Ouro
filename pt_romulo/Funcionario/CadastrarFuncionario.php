<?php


// Conexão com o banco de dados
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_rainhadoouro';

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Receber dados do formulário
$nome_completo = $_POST['nome_completo'];
$data_nascimento = $_POST['data_nascimento'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$sexo = $_POST['sexo'];
$estado_civil = $_POST['estado_civil'];
$telefone = $_POST['telefone'];
$cep = $_POST['cep'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cargo = $_POST['cargo'];
$horario_trabalho = $_POST['horario_trabalho'];
$salario = $_POST['salario'];
$tipo_contrato = $_POST['tipo_contrato'];
$carteira_trabalho = $_POST['carteira_trabalho'];
$pis = $_POST['pis'];
$observacoes = $_POST['observacoes'];
$tipo_funcionario = $_POST['tipo_funcionario']; // adm, atendente ou cabeleleira

// Valores adicionais padrão
$data_admissao = date('Y-m-d');
$status = 'Ativo';
$data_cadastro = date('Y-m-d H:i:s');

// Gerar e-mail automático com base no nome e tipo
$nome_explodido = explode(' ', strtolower($nome_completo));
$primeiro_nome = $nome_explodido[0];
$ultimo_nome = end($nome_explodido);
$email_gerado = "$primeiro_nome.$ultimo_nome@$tipo_funcionario.com";

// Gerar senha padrão (criptografada)
$senha_padrao = password_hash('123456', PASSWORD_DEFAULT);

// Preparar e executar o INSERT na tabela tb_funcionarios
$stmt = $conn->prepare("INSERT INTO tb_funcionarios (
    nome_completo, data_nascimento, cpf, rg, sexo, estado_civil, telefone, email,
    cep, rua, numero, bairro, cidade, estado, cargo, data_admissao, horario_trabalho, salario,
    tipo_contrato, carteira_trabalho, pis, status, observacoes, data_cadastro, tipo_funcionario
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssssssssssssssssssssss",
    $nome_completo, $data_nascimento, $cpf, $rg, $sexo, $estado_civil, $telefone, $email_gerado,
    $cep, $rua, $numero, $bairro, $cidade, $estado, $cargo, $data_admissao, $horario_trabalho,
    $salario, $tipo_contrato, $carteira_trabalho, $pis, $status, $observacoes, $data_cadastro, $tipo_funcionario
);

// Executar e verificar sucesso
if ($stmt->execute()) {
    $id_funcionario = $stmt->insert_id;

    // Inserir na tb_login
    $stmt_login = $conn->prepare("INSERT INTO tb_login (
        email, senha, tipo_usuario, id_referencia, status, data_criacao
    ) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt_login->bind_param("sssiss", $email_gerado, $senha_padrao, $tipo_funcionario, $id_funcionario, $status, $data_cadastro);
    $stmt_login->execute();
echo "<script>
    alert('Funcionário cadastrado com sucesso!');
    window.location.href = 'FormCadastrarFuncionario.html';
</script>";
exit();
} else {
    echo "<script>
    alert('Erro ao cadastrar funcionário');
    window.location.href = 'FormCadastrarFuncionario.html';
</script>";
}

$stmt->close();
$conn->close();
?>
