document.querySelector('.payment-form').addEventListener('submit', function (e) {
    const validadeInput = document.getElementById('validade');
    const validade = validadeInput.value.trim();
    const regex = /^(0[1-9]|1[0-2])\/(\d{2}|\d{4})$/;

    if (!regex.test(validade)) {
        alert("Formato da data inválido. Use MM/AA ou MM/AAAA.");
        validadeInput.focus();
        e.preventDefault();
        return;
    }

    const [mesStr, anoStr] = validade.split('/');
    const mes = parseInt(mesStr, 10);
    let ano = parseInt(anoStr, 10);

    if (anoStr.length === 2) {
        // Supõe-se que datas "25" significam "2025"
        ano += 2000;
    }

    const hoje = new Date();
    const mesAtual = hoje.getMonth() + 1; // 0-indexed
    const anoAtual = hoje.getFullYear();

    if (ano < anoAtual || (ano === anoAtual && mes < mesAtual)) {
        alert("A data de validade está expirada.");
        validadeInput.focus();
        e.preventDefault();
    }
});

