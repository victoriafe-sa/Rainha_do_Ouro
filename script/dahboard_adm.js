// Função para alternar visibilidade do submenu
document.querySelectorAll('.button_ai-open-envelope_rc').forEach(item => {
    item.addEventListener('click', event => {
        const submenu = document.querySelector('.submenu_rc');
        const arrow = document.querySelector('.arrow-icon_rc');
        submenu.classList.toggle('active');
        arrow.classList.toggle('rotate');
    });
});

// Ajuste de largura ao passar o mouse na sidebar
const sidebar_rc = document.querySelector('.sidebar_rc');

sidebar_rc.addEventListener('mouseover', () => {
    sidebar_rc.style.width = '300px';
    const right = document.querySelector('.right_rc');
    if (right) right.style.width = '225px';
});

sidebar_rc.addEventListener('mouseout', () => {
    sidebar_rc.style.width = '80px';
    const right = document.querySelector('.right_rc');
    if (right) right.style.width = 'auto';
});

// Navegação entre páginas
function carregarPagina(caminho) {
    fetch(caminho)
        .then(response => response.text())
        .then(html => {
            document.getElementById('conteudo').innerHTML = html;
            // Opcional: depois de carregar, pode disparar algum evento para ativar scripts das páginas carregadas
        })
        .catch(erro => {
            document.getElementById('conteudo').innerHTML = "<p>Erro ao carregar a página.</p>";
        });
}

function carregarPagina(caminho) {
  fetch(caminho)
    .then(response => response.text())
    .then(html => {
      document.getElementById('conteudo').innerHTML = html;

      // Carrega JS necessário após injetar o HTML
      if (caminho.includes('cadastro_serv-prod.html')) {
        const script = document.createElement('script');
        script.src = '../script/cadastro_serv-prod.js';
        script.defer = true;
        document.body.appendChild(script);
      }
      if (caminho.includes('agendamentos.html')) {
        const script = document.createElement('script');
        script.src = '../script/agendamentos.js';
        script.defer = true;
        document.body.appendChild(script);
      }

    })
    .catch(() => {
      document.getElementById('conteudo').innerHTML = "<p>Erro ao carregar a página.</p>";
    });
}
