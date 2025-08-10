document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('container');
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');

    // Aplica a classe 'show' para surgir na tela ao carregar
    setTimeout(() => {
        container.classList.add('show');
    }, 300); // Pequeno delay para suavidade

    // Clique em "Criar conta" (ativa o painel da direita)
    signUpButton.addEventListener('click', () => {
        container.classList.add('right-panel-active');
    });

    // Clique em "Fazer login" (volta ao painel da esquerda)
    signInButton.addEventListener('click', () => {
        container.classList.remove('right-panel-active');
    });
});
document.getElementById('phone').addEventListener('input', function(e) {
    let x = e.target.value.replace(/\D/g, '').substring(0, 11);
    let formatted = '';

    if (x.length > 10) {
        // (12) 34567-8901
        formatted = x.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
    } else if (x.length > 5) {
        // (12) 3456-7890
        formatted = x.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
    } else if (x.length > 2) {
        formatted = x.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
    } else {
        formatted = x;
    }
    e.target.value = formatted;
});


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


