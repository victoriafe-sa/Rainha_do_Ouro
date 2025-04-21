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
