<?php

// Baixar a biblioteca: 'composer require phpmailer/phpmailer'

// Importa as classes PHPMailer e Exception do namespace PHPMailer\PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carrega automaticamente todas as classes da biblioteca PHPMailer via Composer
require 'vendor/autoload.php';

// Verifica se o formulário foi enviado via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Captura os dados enviados pelo formulário HTML
    $para = $_POST["para"];         // E-mail do destinatário
    $assunto = $_POST["assunto"];   // Assunto do e-mail
    $mensagem = $_POST["mensagem"]; // Corpo do e-mail

    // Cria uma nova instância do PHPMailer com tratamento de exceções ativado
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP do Gmail
        $mail->isSMTP();                         // Define o uso de SMTP
        $mail->Host       = 'smtp.gmail.com';    // Servidor SMTP do Gmail
        $mail->SMTPAuth   = true;                // Ativa autenticação SMTP
        $mail->Username   = 'victoria.senac.13@gmail.com'; // Seu e-mail do Gmail
        $mail->Password   = 'bwxl jxgi luso gbtr';         // Senha de app (não é sua senha normal!)
        $mail->SMTPSecure = 'tls';               // Criptografia TLS
        $mail->Port       = 587;                 // Porta SMTP (TLS geralmente usa 587)

        // Define quem está enviando o e-mail (remetente)
        $mail->setFrom('victoria.senac.13@gmail.com', 'Rainha do Ouro');

        // Define o destinatário do e-mail
        $mail->addAddress($para); // O e-mail digitado pelo usuário

        // Define o conteúdo do e-mail
        $mail->isHTML(true);                         // Permite conteúdo em HTML
        $mail->Subject = $assunto;                   // Define o assunto do e-mail
        $mail->Body    = nl2br($mensagem);           // Corpo do e-mail com quebras de linha convertidas em <br>
        $mail->AltBody = $mensagem;                  // Corpo do e-mail alternativo (sem HTML)

        // Envia o e-mail
        $mail->send();

        // Mensagem de sucesso
        echo "E-mail enviado com sucesso para <strong>$para</strong>!";
    } catch (Exception $e) {
        // Em caso de erro, exibe a mensagem de erro
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
    }
}
?>
