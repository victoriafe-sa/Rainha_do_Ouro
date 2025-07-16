function buscarCep() {
    const cep = document.getElementById("cep").value.replace(/\D/g, '');
    if (cep.length !== 8) return;

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                document.getElementById("rua").value = data.logradouro || "";
                document.getElementById("bairro").value = data.bairro || "";
                document.getElementById("cidade").value = data.localidade || "";
                document.getElementById("estado").value = data.uf || "";
                document.getElementById("numero").value = data.numero|| "";
            } else {
                alert("CEP não encontrado.");
            }
        })
        .catch(() => alert("Erro ao buscar o CEP."));
}

// Preencher automaticamente a data de cadastro com a data atual
window.onload = function () {
    const hoje = new Date().toISOString().split('T')[0];
    document.getElementById("data_cadastro").value = hoje;
};