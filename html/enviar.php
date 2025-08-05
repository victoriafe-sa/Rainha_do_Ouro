<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rainhadoouro";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servico = $_POST['service'] ?? '';
    $tipoServico = $_POST['tipoServico'] ?? '';
    $data = $_POST['data'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';

    $horario = $horario . ":00"; // formato HH:MM:SS

    // Montar nome completo do cliente
    $nomeCompleto = trim($nome . ' ' . $sobrenome);

    // Verificar se cliente já existe (opcional)
    $stmtVerificaCliente = $conn->prepare("SELECT id_clientes FROM tb_clientes WHERE email = ?");
    $stmtVerificaCliente->bind_param("s", $email);
    $stmtVerificaCliente->execute();
    $res = $stmtVerificaCliente->get_result();

    if ($res->num_rows > 0) {
        // Cliente já existe, pegar id
        $row = $res->fetch_assoc();
        $idCliente = $row['id_clientes'];
    } else {
        // Inserir cliente
        // Para simplificar, só vamos inserir nome, email e telefone. Outros campos você pode preencher depois
        $stmtCliente = $conn->prepare("INSERT INTO tb_clientes (nome, telefone, email, data_nascimento, senha, cep, rua, numero, bairro, cidade, estado) VALUES (?, ?, ?, '1900-01-01', '', '', '', 0, '', '', '')");
        $stmtCliente->bind_param("sss", $nomeCompleto, $telefone, $email);
        if (!$stmtCliente->execute()) {
            die("Erro ao inserir cliente: " . $stmtCliente->error);
        }
        $idCliente = $stmtCliente->insert_id;
    }

    // Verificar se já existe agendamento no mesmo dia e horário para esse serviço
    $stmtVerificaAgendamento = $conn->prepare("SELECT * FROM tb_agendamentos WHERE data = ? AND horario = ? AND servico = ?");
    $stmtVerificaAgendamento->bind_param("sss", $data, $horario, $servico);
    $stmtVerificaAgendamento->execute();
    $resAgendamento = $stmtVerificaAgendamento->get_result();

    if ($resAgendamento->num_rows > 0) {
        die("Já existe um agendamento para essa data, horário e serviço.");
    }

    // Inserir agendamento
    $stmtAgendamento = $conn->prepare("INSERT INTO tb_agendamentos (servico, tipoServico, data, horario, status) VALUES (?, ?, ?, ?, 'agendado')");
    $stmtAgendamento->bind_param("ssss", $servico, $tipoServico, $data, $horario);

    if ($stmtAgendamento->execute()) {
        echo "Agendamento realizado com sucesso!";
        // Aqui você pode colocar o código para enviar email usando PHPMailer
    } else {
        die("Erro ao inserir agendamento: " . $stmtAgendamento->error);
    }
}

$conn->close();
?>
