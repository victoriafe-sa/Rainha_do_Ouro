document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  const appointmentsTable = document.getElementById('appointmentsTable');
  const modalEditar = document.getElementById('modalEditar');
  const formEditar = document.getElementById('formEditar');

  // Função para aplicar filtro na tabela
  function aplicarFiltro() {
    const filter = searchInput.value.toLowerCase();
    const rows = appointmentsTable.querySelectorAll('tr');
    rows.forEach(row => {
      const cells = row.querySelectorAll('td');
      const match = Array.from(cells).some(td => td.textContent.toLowerCase().includes(filter));
      row.style.display = match ? '' : 'none';
    });
  }

  // Função para carregar agendamentos via fetch
  function carregarAgendamentos() {
    fetch('../crud/carregar_agendamentos.php')
      .then(res => {
        if (!res.ok) throw new Error('Erro ao carregar agendamentos');
        return res.text();
      })
      .then(html => {
        appointmentsTable.innerHTML = html;
        aplicarFiltro(); // reaplica filtro após carregar
      })
      .catch(err => {
        appointmentsTable.innerHTML = `<tr><td colspan="7" class="text-danger text-center">${err.message}</td></tr>`;
        console.error(err);
      });
  }

  // Evento input para filtro
  searchInput.addEventListener('input', aplicarFiltro);

  // Abre modal e preenche com dados da linha
  window.abrirModalEditar = function(button) {
    const tr = button.closest('tr');
    document.getElementById('id_agendamento').value = tr.dataset.id;
    document.getElementById('data').value = tr.dataset.data;
    document.getElementById('horario').value = tr.dataset.horario;
    document.getElementById('status').value = tr.dataset.status;
    document.getElementById('servico').value = tr.dataset.servico;
    document.getElementById('tipoServico').value = tr.dataset.tiposervico;
    modalEditar.style.display = 'block';
  };

  // Fecha modal
  window.fecharModal = function() {
    modalEditar.style.display = 'none';
  };

  // Fecha modal se clicar fora
  window.onclick = function(event) {
    if (event.target === modalEditar) {
      fecharModal();
    }
  };

  // Submissão do formulário de edição
  formEditar.addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(formEditar);

    fetch('../crud/editar_agendamento.php', {
      method: 'POST',
      body: formData,
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Agendamento atualizado com sucesso!');
        fecharModal();
        carregarAgendamentos();
      } else {
        alert('Erro: ' + (data.error || 'Erro desconhecido'));
      }
    })
    .catch(() => alert('Erro ao conectar ao servidor.'));
  });

  // Função excluir agendamento
  window.excluirAgendamento = function(id) {
    if (!confirm('Deseja realmente excluir o agendamento ID ' + id + '?')) return;

    const formData = new FormData();
    formData.append('id_agendamento', id);

    fetch('../crud/excluir_agendamento.php', {
      method: 'POST',
      body: formData,
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Agendamento excluído com sucesso!');
        carregarAgendamentos();
      } else {
        alert('Erro: ' + (data.error || 'Erro desconhecido'));
      }
    })
    .catch(() => alert('Erro ao conectar ao servidor.'));
  };

  // Inicializa carregando agendamentos
  carregarAgendamentos();
});
// dentro do seu arquivo JS ou script tag

document.getElementById('formEditar').addEventListener('submit', e => {
  e.preventDefault();
  const formData = new FormData(e.target);
  fetch('../crud/editar_agendamento.php', {  // caminho atualizado
    method: 'POST',
    body: formData,
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('Agendamento atualizado com sucesso!');
      fecharModal();
      carregarAgendamentos();
    } else {
      alert('Erro: ' + (data.message || 'Erro desconhecido'));
    }
  })
  .catch(() => alert('Erro ao conectar ao servidor.'));
});

function excluirAgendamento(id) {
  if (!confirm('Deseja realmente excluir o agendamento ID ' + id + '?')) return;

  const formData = new FormData();
  formData.append('id', id);

  fetch('../crud/excluir_agendamento.php', {  // caminho atualizado
    method: 'POST',
    body: formData,
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('Agendamento excluído com sucesso!');
      carregarAgendamentos();
    } else {
      alert('Erro: ' + (data.message || 'Erro desconhecido'));
    }
  })
  .catch(() => alert('Erro ao conectar ao servidor.'));
}
