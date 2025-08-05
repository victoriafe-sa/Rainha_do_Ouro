function validaCPF(cpf) {
    cpf = cpf.replace(/\D+/g, '');
    if (cpf.length !== 11) return false;
    if (/^(\d)\1{10}$/.test(cpf)) return false;

    let soma = 0, resto;

    for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) return false;

    soma = 0;
    for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) return false;

    return true;
}

document.getElementById('cpf').addEventListener('input', function (e) {
    var value = e.target.value;
    var cpfPattern = value.replace(/\D/g, '')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1-$2')
        .replace(/(-\d{2})\d+?$/, '$1');
    e.target.value = cpfPattern;
});

function limpa_formulário_cep() {
    document.getElementById('logradouro').value = "";
    document.getElementById('bairro').value = "";
    document.getElementById('cidade').value = "";
    document.getElementById('estado').value = "";
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        document.getElementById('estado').value = (conteudo.uf);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
        document.getElementById('logradouro').value = (conteudo.logradouro);
    } else {
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {
    var cep = valor.replace(/\D/g, '');
    if (cep !== "") {
        var validacep = /^[0-9]{8}$/;
        if (validacep.test(cep)) {
            document.getElementById('estado').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            document.getElementById('logradouro').value = "...";
            var script = document.createElement('script');
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';
            document.body.appendChild(script);
        } else {
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } else {
        limpa_formulário_cep();
    }
}

// FORM SUBMIT
document.getElementById('formUser').addEventListener('submit', function (e) {
    e.preventDefault();

    const cpf = document.getElementById('cpf').value;
    if (!validaCPF(cpf)) {
        alert('CPF inválido. Verifique o número digitado.');
        document.getElementById('cpf').focus();
        return;
    }

    const nome = document.getElementById('nome').value;
    const emailUser = document.getElementById('email-user').value;

    const assunto = 'Cadastro no site Rainha do Ouro';
    const mensagem = `Olá ${nome},\n\nSeja muito bem-vindo(a) ao Rainha do Ouro! 💛\nAgora você faz parte da nossa comunidade e poderá agendar seus serviços de beleza com mais praticidade.\n\n✨ Seu cadastro foi realizado com sucesso!\n\nEstamos felizes em ter você com a gente!\n\nCom carinho,\nEquipe Rainha do Ouro.\n\nAcesse: https://www.rainhadoouro.com.br`;

    // Simula envio de e-mail via mailto
    window.location.href = `mailto:${emailUser}?subject=${encodeURIComponent(assunto)}&body=${encodeURIComponent(mensagem)}`;

    alert('Cadastro realizado com sucesso! Verifique seu e-mail.');
});
