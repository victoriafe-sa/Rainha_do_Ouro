// Gerenciar visibilidade do submenu ao clicar no botão de mensagens
document.querySelectorAll('.button_ai-open-envelope_rc').forEach(item => {
    item.addEventListener('click', () => {
        const submenu = document.querySelector('.submenu_rc');
        const arrow = document.querySelector('.arrow-icon_rc');
        if (submenu) submenu.classList.toggle('active');
        if (arrow) arrow.classList.toggle('rotate');
    });
});

// Ajuste de largura ao passar o mouse na sidebar (para .sidebar_rc)
const sidebar_rc = document.querySelector('.sidebar_rc');
if (sidebar_rc) {
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
}

// Ajuste de largura ao passar o mouse na sidebar (para .sidebar)
const sidebar = document.querySelector('.sidebar');
if (sidebar) {
    sidebar.addEventListener('mouseover', () => {
        sidebar.style.width = '300px';
        const right = document.querySelector('.right');
        if (right) right.style.width = '225px';
    });
    sidebar.addEventListener('mouseout', () => {
        sidebar.style.width = '80px';
        const right = document.querySelector('.right');
        if (right) right.style.width = 'auto';
    });
}

// Carregar páginas dinâmicas com JS extra opcional
function carregarPagina(caminho) {
    fetch(caminho)
        .then(response => response.text())
        .then(html => {
            document.getElementById('conteudo').innerHTML = html;

            // Injetar JS adicional se necessário
            if (caminho.includes('../Produto_Serviço/FormCadastrarProduto_Serviço.html')) {
                const script = document.createElement('script');
                script.src = '../script/cadastro_serv-prod.js';
                script.defer = true;
                document.body.appendChild(script);
            }
        })
        .catch(() => {
            document.getElementById('conteudo').innerHTML = "<p>Erro ao carregar a página.</p>";
        });
}

// Opcional: Atualizar badges (exemplo)
function updateBadgeCounts() {
    const messagesBadge = document.querySelector('.messages-badge');
    const draftsBadge = document.querySelector('.drafts-badge');
    if (messagesBadge) messagesBadge.textContent = 12; // Exemplo
    if (draftsBadge) draftsBadge.textContent = 10;     // Exemplo
}
document.addEventListener('DOMContentLoaded', updateBadgeCounts);



