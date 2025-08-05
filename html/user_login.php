<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login/Cadastro - Rainha do Ouro</title>
    <link rel="stylesheet" href="../css/user_login.css">
</head>

<body>
  <div class="container" id="container">

    <!-- Cadastro -->
    <div class="form-container sign-up-container">
      <form action="../crud/CadastrarCliente.php" method="POST">
        <h1>Criar Conta</h1>
        <input type="text" name="nome" placeholder="Nome completo" required />
        <input type="text" name="telefone" id="phone" placeholder="Telefone" required />
        <input type="date" name="data_nascimento" id="data" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="senha" id="senha" placeholder="Senha" required />
        <input type="text" name="cpf" id="cpf" placeholder="CPF" required />
        <input type="text" name="cep" id="cep" placeholder="CEP" required />
        <input type="text" name="rua" placeholder="Rua" required />
        <input type="number" name="numero" placeholder="Número" required />
        <input type="text" name="bairro" placeholder="Bairro" required />
        <input type="text" name="cidade" placeholder="Cidade" required />
        <input type="text" name="estado" placeholder="Estado (ex: SP)" maxlength="2" required />
        <button type="submit">Cadastrar</button>
      </form>
    </div>

    <!-- Login -->
    <div class="form-container sign-in-container">
      <form action="../crud/ValidarLoginCliente.php" method="POST">
        <h1>Login</h1>
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="senha" placeholder="Senha" required />
        <button type="submit">Entrar</button>
      </form>
    </div>


    <!-- Painel de troca -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Bem-vindo de volta!</h1>
          <p>Para continuar conectado, faça login com seus dados</p>
          <button class="ghost" id="signIn">Login</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Olá, Cliente!</h1>
          <p>Insira seus dados e comece sua jornada conosco</p>
          <button class="ghost" id="signUp">Cadastrar</button>
        </div>
      </div>
    </div>
  </div>
  <script src="../script2/user_login.js"></script>
  <!-- Script para alternar login/cadastro -->
  <script>
    const signUpButton = document.getElementById("signUp");
    const signInButton = document.getElementById("signIn");
    const container = document.getElementById("container");

    signUpButton.addEventListener("click", () =>
      container.classList.add("right-panel-active")
    );

    signInButton.addEventListener("click", () =>
      container.classList.remove("right-panel-active")
    );
  </script>
</body>

</html>