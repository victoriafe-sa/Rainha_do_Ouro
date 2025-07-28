const tabs = document.querySelectorAll('.tab-btn');
const contents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        // Remove a classe 'active' de todos os botões e conteúdos
        tabs.forEach(btn => btn.classList.remove('active'));
        contents.forEach(content => content.classList.remove('active'));

        // Adiciona a classe 'active' ao botão clicado e ao conteúdo correspondente
        tab.classList.add('active');
        const activeContent = document.getElementById(tab.dataset.tab);
        if (activeContent) {
            activeContent.classList.add('active');
        }
    });
});