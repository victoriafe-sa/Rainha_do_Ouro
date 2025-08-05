document.addEventListener("DOMContentLoaded", () => {
    const cepInput = document.getElementById("cep");

    cepInput.addEventListener("blur", () => {
        const cep = cepInput.value.replace(/\D/g, '');

        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById("logradouro").value = data.logradouro;
                        document.getElementById("bairro").value = data.bairro;
                        document.getElementById("cidade").value = data.localidade;
                        document.getElementById("estado").value = data.uf;
                    } else {
                        alert("CEP não encontrado.");
                    }
                })
                .catch(error => {
                    console.error("Erro ao buscar o CEP:", error);
                    alert("Erro ao buscar o CEP.");
                });
        } else {
            alert("CEP inválido.");
        }
    });
});
