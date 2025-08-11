<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Verifica se usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    echo "<script>alert('Você precisa estar logado para agendar.'); window.location.href = '../html/user_login.php';</script>";
    exit;
}

$idCliente = $_SESSION['id_cliente'];

$servidor = "localhost";
$dbusuario = "root";
$dbsenha = "";
$dbname = "db_rainhadoouro";

$conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe dados do POST, com fallback para string vazia
    $servico = $_POST["service"] ?? '';
    $tipoServico = $_POST["tipoServico"] ?? '';
    $data = $_POST["data"] ?? '';
    $horario = $_POST["horario"] ?? '';
    $nome = $_POST["nome"] ?? '';
    $sobrenome = $_POST["sobrenome"] ?? '';
    $email = $_POST["email"] ?? '';
    $telefone = $_POST["telefone"] ?? '';

    $horario = $horario . ':00'; // formata para HH:MM:SS

    // Verifica se já existe agendamento no mesmo dia e horário
    $stmt = $conn->prepare("SELECT * FROM tb_agendamentos WHERE data = ? AND horario = ?");
    $stmt->bind_param("ss", $data, $horario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>alert('Já existe um agendamento para essa data e horário.'); window.location.href = '../html/agendamentos.php';</script>";
        exit;
    } else {
        // Inserir agendamento com o id do cliente logado
        $stmt = $conn->prepare("INSERT INTO tb_agendamentos (servico, tipoServico, data, horario, nome, sobrenome, email, telefone, tb_clientes_id_clientes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssi", $servico, $tipoServico, $data, $horario, $nome, $sobrenome, $email, $telefone, $idCliente);

        if ($stmt->execute()) {
            // Enviar email de confirmação
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'victoria.senac.13@gmail.com'; // seu email
                $mail->Password = 'bwxl jxgi luso gbtr'; // sua senha/senha de app
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('victoria.senac.13@gmail.com', 'Rainha do Ouro');
                $mail->addAddress($email, "$nome $sobrenome");

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8'; // n perde a configuração do caracter especial
                $mail->Encoding = 'base64'; // n perde a configuração do caracter especial 
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

                header("Location: ../html/agendamentos.php#sucesso");
                exit;
            } catch (Exception $e) {
                echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
            }
        } else {
            echo "Erro ao salvar no banco: " . $stmt->error;
        }
    }
}

mysqli_close($conn);
?>
