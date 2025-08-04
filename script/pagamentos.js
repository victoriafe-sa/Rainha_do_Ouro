document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".payment-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // sempre evita o envio do form

        // VALIDAÇÃO DO NOME
        const nome = document.getElementById('nome').value.trim();
        if (nome === "") {
            alert("Por favor, preencha o nome completo.");
            document.getElementById('nome').focus();
            return;
        }

        // VALIDAÇÃO DO NÚMERO DO CARTÃO
        const numero = document.getElementById('numero').value.replace(/\s+/g, '');
        if (!/^\d{13,19}$/.test(numero)) {
            alert("Número do cartão inválido. Deve conter entre 13 e 19 dígitos.");
            document.getElementById('numero').focus();
            return;
        }

        // VALIDAÇÃO DO CVV
        const cvv = document.getElementById('codigo').value.trim();
        if (!/^\d{3,4}$/.test(cvv)) {
            alert("CVV inválido. Deve conter 3 ou 4 dígitos.");
            document.getElementById('codigo').focus();
            return;
        }

        // VALIDAÇÃO DA DATA DE VALIDADE
        const validadeInput = document.getElementById('validade');
        const validade = validadeInput.value.trim();
        const regex = /^(0[1-9]|1[0-2])\/(\d{2}|\d{4})$/;

        if (!regex.test(validade)) {
            alert("Formato da data inválido. Use MM/AA ou MM/AAAA.");
            validadeInput.focus();
            return;
        }

        const [mesStr, anoStr] = validade.split('/');
        const mes = parseInt(mesStr, 10);
        let ano = parseInt(anoStr, 10);
        if (anoStr.length === 2) {
            ano += 2000;
        }

        const hoje = new Date();
        const mesAtual = hoje.getMonth() + 1;
        const anoAtual = hoje.getFullYear();

        if (ano < anoAtual || (ano === anoAtual && mes < mesAtual)) {
            alert("A data de validade está expirada.");
            validadeInput.focus();
            return;
        }

        // ✅ SE TUDO ESTIVER CORRETO
        alert("Pagamento realizado com sucesso!");

        // Aguarda o alerta ser exibido antes de redirecionar
        setTimeout(function () {
            window.location.href = "../html/pagina_inicial.html";
        }, 100);
    });
});
