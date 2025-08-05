document.addEventListener("DOMContentLoaded", () => {
  const filtrosAvancadosCheckbox = document.getElementById("filtrosAvancados");
  const filtrosAvancadosCampos = document.getElementById("filtrosAvancadosCampos");

  filtrosAvancadosCheckbox.addEventListener("change", () => {
    if (filtrosAvancadosCheckbox.checked) {
      filtrosAvancadosCampos.style.display = "flex";
    } else {
      filtrosAvancadosCampos.style.display = "none";
    }
  });

  filtrosAvancadosCampos.style.display = "none"; // Oculta ao carregar a página
});

// Função chamada ao enviar o formulário
function pesquisarFuncionarios() {
  const nome = document.getElementById("nome").value;
  const departamento = document.getElementById("departamento").value;
  const status = document.getElementById("status").value;
  const cargo = document.getElementById("cargo").value;
  const dataAdmissaoDe = document.getElementById("dataAdmissaoDe").value;
  const dataAdmissaoAte = document.getElementById("dataAdmissaoAte").value;

  fetch('../php/buscar_funcionarios.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      nome,
      departamento,
      status,
      cargo,
      dataAdmissaoDe,
      dataAdmissaoAte
    })
  })
  .then(response => response.json())
  .then(data => {
    atualizarTabela(data);
  })
  .catch(error => {
    console.error('Erro na busca:', error);
    alert("Erro ao buscar funcionários.");
  });
}

function atualizarTabela(funcionarios) {
  const tbody = document.querySelector("#tabelaFuncionarios tbody");
  const resultCount = document.getElementById("resultCount");

  tbody.innerHTML = "";

  if (funcionarios.length === 0) {
    resultCount.textContent = "Nenhum funcionário encontrado.";
    tbody.innerHTML = '<tr><td colspan="6" class="no-results">Nenhum resultado para os filtros aplicados.</td></tr>';
    return;
  }

  resultCount.textContent = `${funcionarios.length} funcionário(s) encontrado(s).`;

  funcionarios.forEach(func => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${func.id_funcionarios}</td>
      <td>${func.nome_completo}</td>
      <td>${func.cargo}</td>
      <td>${func.departamento}</td>
      <td>${func.status}</td>
      <td><button onclick="alert('Funcionalidade futura!')">Ver mais</button></td>
    `;
    tbody.appendChild(tr);
  });
}

function resetFiltrosAvancados() {
  document.getElementById("filtrosAvancados").checked = false;
  document.getElementById("filtrosAvancadosCampos").style.display = "none";
}
