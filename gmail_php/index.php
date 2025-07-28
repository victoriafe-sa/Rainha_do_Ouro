<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Enviar E-mail com PHP</title>
</head>
<body>
  <h2>Enviar E-mail com Gmail (PHP)</h2>
  <form action="enviar.php" method="post">
    <label>Para (destinatário):</label><br>
    <input type="email" name="para" required><br><br>

    <label>Assunto:</label><br>
    <input type="text" name="assunto" required><br><br>

    <label>Mensagem:</label><br>
    <textarea name="mensagem" rows="6" cols="40" required></textarea><br><br>

    <input type="submit" value="Enviar E-mail">
  </form>
</body>
</html>
