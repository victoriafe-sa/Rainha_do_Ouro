// script.js

// Função para inicializar eventos
function init() {
    // Seleciona todos os botões no menu
    const menuButtons = document.querySelectorAll('.sidebar button');

    // Adiciona um ouvinte de evento de clique a cada botão
    menuButtons.forEach(button => {
        button.addEventListener('click', () => {
            const buttonText = button.querySelector('span') ? button.querySelector('span').textContent : 'Botão';
            alert(`Você clicou em: ${buttonText}`);
        });
    });
}

// Chama a função init quando o documento estiver pronto
document.addEventListener('DOMContentLoaded', init);