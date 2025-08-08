<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login/Cadastro | Rainha do Ouro</title>
  <link rel="stylesheet" href="../css/user_login.css">
  <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">

  <style>
    /* Estilos do modal de recuperação de senha */
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
  <!-- Script para alternar login/cadastro -->
  <script>
  // Referências aos elementos do DOM
const signUpButton = document.getElementById("signUp");
const signInButton = document.getElementById("signIn");
const container = document.getElementById("container");

const btnEsqueceuSenha = document.getElementById('btnEsqueceuSenha');
const modal = document.getElementById('modalRecuperarSenha');
const fechar = document.getElementById('fecharModal');

const formRecuperar = document.getElementById('formRecuperar');
const formNovaSenha = document.getElementById('formNovaSenha');
const passo1 = document.getElementById('passo1');
const passo2 = document.getElementById('passo2');

// Alterna entre as telas de login e cadastro
signUpButton.addEventListener("click", () =>
  container.classList.add("right-panel-active")
);

signInButton.addEventListener("click", () =>
  container.classList.remove("right-panel-active")
);

// Abrir modal de recuperação de senha
btnEsqueceuSenha.addEventListener('click', () => {
  passo1.style.display = 'block';  // garante que começa no passo 1
  passo2.style.display = 'none';
  modal.style.display = 'block';
});

// Fechar modal
fechar.addEventListener('click', () => {
  modal.style.display = 'none';
});

// Fechar modal clicando fora do conteúdo
window.addEventListener('click', (event) => {
  if (event.target === modal) {
    modal.style.display = 'none';
  }
});

// Envio do formulário do primeiro passo (validar email, telefone e data nascimento)
formRecuperar.addEventListener('submit', async (e) => {
  e.preventDefault();

  const email = document.getElementById('emailRecuperar').value.trim();
  const telefone = document.getElementById('telefoneRecuperar').value.trim();
  const dataNascimento = document.getElementById('dataNascimentoRecuperar').value;

  try {
    const response = await fetch('../crud/RecuperarSenhaCliente.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `email=${encodeURIComponent(email)}&telefone=${encodeURIComponent(telefone)}&data_nascimento=${encodeURIComponent(dataNascimento)}`
    });

    const result = await response.text();

    if (result.trim()=== 'ok') {
      // Se validou, avança para o passo 2 (nova senha)
      passo1.style.display = 'none';
      passo2.style.display = 'block';

      // Preenche os campos ocultos do segundo form
      document.getElementById('emailConfirmar').value = email;
      document.getElementById('telefoneConfirmar').value = telefone;
      document.getElementById('dataNascimentoConfirmar').value = dataNascimento;
    } else {
      alert(result); // mensagem de erro do PHP
    }
  } catch (error) {
    alert('Erro na conexão com o servidor.');
    console.error(error);
  }
});

// Validação do formulário do segundo passo (nova senha)
formNovaSenha.addEventListener('submit', (e) => {
  const novaSenha = document.getElementById('novaSenha').value;
  const confirmarSenha = document.getElementById('confirmarSenha').value;

  if (novaSenha !== confirmarSenha) {
    e.preventDefault();
    alert('As senhas não conferem!');
  }
});


function aplicarMascaraTelefone(valor) {
    valor = valor.replace(/\D/g, "");
    if (valor.length > 10) {
        valor = valor.replace(/^(\d{2})(\d{5})(\d{4})/, "($1)$2-$3");
    } else {
        valor = valor.replace(/^(\d{2})(\d{4})(\d{4})/, "($1)$2-$3");
    }
    return valor;
}

function limparMascaraTelefone(valor) {
    return valor.replace(/\D/g, "");
}

// Máscara no cadastro
const phoneCadastro = document.getElementById('phone');
phoneCadastro.addEventListener('input', function() {
    this.value = aplicarMascaraTelefone(this.value);
});

// Máscara na recuperação
const phoneRecuperar = document.getElementById('telefoneRecuperar');
phoneRecuperar.addEventListener('input', function() {
    this.value = aplicarMascaraTelefone(this.value);
});

// Remove máscara antes de enviar os forms
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
        const telInput = this.querySelector('input[name="telefone"]');
        if (telInput) {
            telInput.value = limparMascaraTelefone(telInput.value);
        }
    });
});



  </script>
</body>

</html>
