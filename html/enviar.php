<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Conexão com o banco
$servidor = "localhost";
$dbusuario = "root";
$dbsenha = "";
$dbname = "db_rainhadoouro";

$conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
mysqli_select_db($conn, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servico = $_POST["service"] ?? '';
    $tipoServico = $_POST["tipoServico"] ?? '';
    $data = $_POST["data"] ?? '';         // Ex: 2025-08-15
    $horario = $_POST["horario"] ?? '';   // Ex: 14:00
    $nome = $_POST["nome"] ?? '';
    $sobrenome = $_POST["sobrenome"] ?? '';
    $email = $_POST["email"] ?? '';
    $telefone = $_POST["telefone"] ?? '';

    // Simulação de seleção de funcionário e pagamento
    $id_funcionario = 1; // ID de funcionário válido
    $id_pagamento = 1;   // ID de pagamento válido

    // ✅ Garante que o horário esteja no formato TIME (HH:MM:SS)
    $horario = $horario . ':00';

    // Concatena data e hora em formato DATETIME (se precisar no futuro)
    $data_hora = $data . ' ' . $horario;

    // Verifica se o funcionário já tem agendamento nesta data e horário
    $stmt = $conn->prepare("SELECT * FROM tb_agendamentos WHERE data = ? AND horario = ? AND tb_funcionarios_id_funcionarios = ?");
    $stmt->bind_param("ssi", $data, $horario, $id_funcionario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>
                alert('Este horário já está reservado para esse funcionário. Por favor, escolha outro.');
                window.history.back();
              </script>";
        exit;
    }

    // Insere o agendamento
    $stmt = $conn->prepare("
    INSERT INTO tb_agendamentos (
        data, horario, status, tb_funcionarios_id_funcionarios, tb_pagamentos_id_pagamentos,
        nome, sobrenome, email, telefone, servico, tipoServico
    ) VALUES (?, ?, 'agendado', ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssiiissssss", $data, $horario, $id_funcionario, $id_pagamento, $nome, $sobrenome, $email, $telefone, $servico, $tipoServico);



    if ($stmt->execute()) {
        // Enviar email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'victoria.senac.13@gmail.com';
            $mail->Password = 'bwxl jxgi luso gbtr';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('victoria.senac.13@gmail.com', 'Rainha do Ouro');
            $mail->addAddress($email, "$nome $sobrenome");

            $mail->isHTML(true);
            $mail->Subject = 'Agendamento de Serviço - Rainha do Ouro';
            $mail->Body = "
                <h2>Agendamento Confirmado!</h2>
                <p><strong>Nome:</strong> $nome $sobrenome</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Telefone:</strong> $telefone</p>
                <p><strong>Serviço:</strong> $servico</p>
                <p><strong>Tipo de Serviço:</strong> $tipoServico</p>
                <p><strong>Data:</strong> $data</p>
                <p><strong>Horário:</strong> $horario</p>
                <br>
                <p>Obrigada por agendar com a gente! 💛</p>
            ";
            $mail->AltBody = "Agendamento confirmado para $nome $sobrenome - Serviço: $servico - Tipo: $tipoServico - Data: $data - Horário: $horario";

            $mail->send();
            header("Location: agendamentos.html#sucesso");
            exit;

        } catch (Exception $e) {
            echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}<br>";
        }
    } else {
        echo "Erro ao salvar no banco: " . $stmt->error;
    }
}

mysqli_close($conn);
?>
