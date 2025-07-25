<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login ADM</title>
  <link rel="stylesheet" href="../css/login_adm.css">
</head>

<body>
  <form action="validar_login.php" method="POST">
    <div class="screen-1">
      <img src="../img/logo.png" alt="">
      <div class="email">
        <label for="email">Email</label>
        <div class="sec-2">
          <ion-icon name="mail-outline"></ion-icon>
          <input type="email" name="email" placeholder="Username@gmail.com" required>
        </div>
      </div>

      <div class="password">
        <label for="senha">Senha</label>
        <div class="sec-2">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <input class="pas" type="password" name="senha" placeholder="********" required>
          <ion-icon class="show-hide" name="eye-outline"></ion-icon>
        </div>
      </div>

      <button class="login" type="submit">Login</button>

      <div class="footer">
        <span>Inscrever-se</span>
        <span>Esqueceu a senha?</span>
      </div>
    </div>
  </form>

</body>

</html>