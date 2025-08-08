<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login/Cadastro | Rainha do Ouro</title>
  <link rel="stylesheet" href="../css/user_login.css">
  <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">

  <style>
    .modal {
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
      display: none;
    }

    .modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 20px;
      border-radius: 8px;
      width: 90%;
      max-width: 400px;
      position: relative;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .fechar {
      position: absolute;
      right: 15px;
      top: 10px;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      user-select: none;
    }
  </style>
</head>

<body>
  <div class="container" id="container">

    <!-- Cadastro -->
    <div class="form-container sign-up-container">
      <form action="../crud/CadastrarCliente_cliente.php" method="POST">
        <h1>Criar Conta</h1>
        <input type="text" name="nome" placeholder="Nome completo" required />
        <input type="text" name="telefone" id="phone" placeholder="Telefone" required />
        <input type="date" name="data_nascimento" id="data" required placeholder="Data de Nascimento" />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="senha" id="senha" placeholder="Senha" required />
        <button type="submit">Cadastrar</button>
      </form>
    </div>

    <!-- Login -->
    <div class="form-container sign-in-container">
      <form action="../crud/ValidarLoginCliente.php" method="POST">
        <h1>Login</h1>
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="senha" placeholder="Senha" required />

        <!-- Campo oculto para redirecionamento -->
        <input type="hidden" name="redirect" value="<?php echo $_GET['redirect'] ?? '../html/pagina_inicial.html'; ?>">

        <button type="submit">Entrar</button>
        <!-- Botão mudou para type="button" e id para controle JS -->
        <button type="button" id="btnEsqueceuSenha">Esqueceu sua senha?</button>
      </form>
    </div>

    <!-- Painel de troca -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Bem-vindo de volta!</h1>
          <p>Para continuar conectado, faça login com seus dados</p>
          <button class="ghost" id="signIn">Entrar</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Olá, Cliente!</h1>
          <p>Insira seus dados e comece sua jornada conosco</p>
          <button class="ghost" id="signUp">Cadastrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para email + CPF -->
<div id="modalRecuperarSenha" class="modal">
  <!-- Passo 1: Validar usuário -->
  <div class="modal-content" id="passo1">
    <span id="fecharModal" class="fechar">&times;</span>
    <h2>Recuperar Senha</h2>
    <form id="formRecuperar" action="../crud/RecuperarSenhaCliente.php" method="POST">
      <label for="emailRecuperar">Digite seu Gmail:</label><br />
      <input type="email" name="email" id="emailRecuperar" placeholder="Gmail" required /><br /><br />
      
      <label for="telefoneRecuperar">Digite seu telefone:</label><br />
      <input type="tel" name="telefone" id="telefoneRecuperar" placeholder="Telefone" required pattern="\(\d{2}\)\d{4,5}-\d{4}" title="Digite seu telefone com 10 ou 11 dígitos numéricos" /><br /><br />
      
      <label for="dataNascimentoRecuperar">Digite sua data de nascimento:</label><br />
      <input type="date" name="data_nascimento" id="dataNascimentoRecuperar" required /><br /><br />
      
      <button type="submit">Enviar</button>
    </form>
  </div>

  <!-- Passo 2: Nova senha -->
  <div class="modal-content" id="passo2" style="display:none;">
    <h2>Digite a nova senha</h2>
    <form id="formNovaSenha" action="../crud/AlterarSenhaLoginCliente.php" method="POST">
      <input type="hidden" name="email" id="emailConfirmar" />
      <input type="hidden" name="telefone" id="telefoneConfirmar" />
      <input type="hidden" name="data_nascimento" id="dataNascimentoConfirmar" />
      
      <label for="novaSenha">Nova senha:</label><br />
      <input type="password" name="nova_senha" id="novaSenha" placeholder="Nova senha" required /><br /><br />
      
      <label for="confirmarSenha">Confirmar senha:</label><br />
      <input type="password" name="confirmar_senha" id="confirmarSenha" placeholder="Confirmar senha" required /><br /><br />
      
      <button type="submit">Alterar Senha</button>
    </form>
  </div>
</div>



  <script src="../script2/user_login.js"></script>

</body>

</html>
