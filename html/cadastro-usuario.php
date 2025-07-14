<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST["nome"]);
    $email = htmlspecialchars($_POST["email"]);

    $assunto = 'Cadastro no site Rainha do Ouro';
    $mensagem = "Olá $nome,\n\nSeja muito bem-vindo(a) ao Rainha do Ouro! 💛
Agora você faz parte da nossa comunidade e poderá agendar seus serviços de beleza com mais praticidade.

✨ Seu cadastro foi realizado com sucesso!

Estamos felizes em ter você com a gente!

Com carinho,
Equipe Rainha do Ouro.

Acesse: https://www.rainhadoouro.com.br";

    $headers = "From: contato@rainhadoouro.com.br\r\n";
    $headers .= "Reply-To: contato@rainhadoouro.com.br\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if (mail($email, $assunto, $mensagem, $headers)) {
        echo "<script>alert('Cadastro realizado com sucesso! E-mail enviado.'); window.location.href = 'cadastro_usuario.html';</script>";
    } else {
        echo "<script>alert('Erro ao enviar e-mail.'); window.history.back();</script>";
    }
}
?>
