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
