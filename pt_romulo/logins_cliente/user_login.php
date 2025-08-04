<?php
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    if ($msg === 'sucesso') {
        echo "<script>alert('Cadastro realizado com sucesso! Faça login para continuar.');</script>";
    } elseif ($msg === 'erro') {
        echo "<script>alert('Erro ao realizar cadastro. Tente novamente.');</script>";
    } elseif ($msg === 'email_existe') {
        echo "<script>alert('Este email já está cadastrado. Use outro email.');</script>";
    } elseif ($msg === 'campos_vazios') {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.');</script>";
    }
    // Limpa a URL após exibir a mensagem
    echo "<script>history.replaceState(null, '', window.location.pathname);</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login e Cadastro</title>
  <link rel="stylesheet" href="../css/user_login.css" />
</head>
<body>
  <div class="container" id="container">
    <!-- Cadastro -->
    <div class="form-container sign-up-container">
      <form action="cadastrar_cliente.php" method="POST">
        <h1>Criar Conta</h1>
        <input type="text" name="nome" placeholder="Nome completo" required />
        <input type="text" name="telefone" id="phone" placeholder="Telefone" required />
        <input type="date" name="data_nascimento" id="data" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="senha" id="senha" placeholder="Senha" required />

        <!-- Campo CPF que estava faltando -->
        <input type="text" name="cpf" id="cpf" placeholder="CPF" required />

        <!-- Endereço -->
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
      <form action="login_cliente.php" method="POST">
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
          <p>Para se manter conectado, faça login com suas credenciais</p>
          <button class="ghost" id="signIn">Fazer login</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Olá!</h1>
          <p>Insira seus dados pessoais para criar sua conta</p>
          <button class="ghost" id="signUp">Criar conta</button>
        </div>
      </div>
    </div>
  </div>

  <script src="../script/user_login.js"></script>
</body>
</html>
