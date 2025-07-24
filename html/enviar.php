<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Configurações do banco
$servidor = "localhost";
$dbusuario = "root";
$dbsenha = "";
$dbname = "db_rainhadoouro";

// Conexão com MySQLi
$conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
mysqli_select_db($conn, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servico = $_POST["service"] ?? '';
    $tipoServico = $_POST["tipoServico"] ?? '';
    $data = $_POST["data"] ?? '';
    $horario = $_POST["horario"] ?? '';
    $nome = $_POST["nome"] ?? '';
    $sobrenome = $_POST["sobrenome"] ?? '';
    $email = $_POST["email"] ?? '';
    $telefone = $_POST["telefone"] ?? '';

    // Inserção no banco (estilo como o exemplo do tb_produtos)
    $sql = "INSERT INTO tb_agendamentos(servico, tipoServico, data, horario) 
            VALUES ('$servico', '$tipoServico', '$data', '$horario')";

    if (mysqli_query($conn, $sql)) {
        // Gravação OK, envia email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'victoria.senac.13@gmail.com'; // seu Gmail
            $mail->Password = 'bwxl jxgi luso gbtr'; // sua senha de app
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

            $mail->AltBody = "Agendamento Confirmado para $nome $sobrenome - Serviço: $servico - Tipo: $tipoServico - Data: $data - Horário: $horario";

            $mail->send();
            header("Location: agendamentos.html#sucesso");
            exit;

        } catch (Exception $e) {
            echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}<br>";
            echo "Detalhes técnicos: " . $e->getMessage();
        }

    } else {
        echo "Erro ao salvar no banco: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>