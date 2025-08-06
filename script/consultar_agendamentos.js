    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', () => {
      const filter = searchInput.value.toLowerCase();
      const rows = document.querySelectorAll('#appointmentsTable tr');
      rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const match = Array.from(cells).some(td => td.textContent.toLowerCase().includes(filter));
        row.style.display = match ? '' : 'none';
      });
    });

    function abrirModalEditar(button) {
      const tr = button.closest('tr');
      document.getElementById('id_agendamento').value = tr.dataset.id;
      document.getElementById('data').value = tr.dataset.data;
      document.getElementById('horario').value = tr.dataset.horario;
      document.getElementById('status').value = tr.dataset.status;
      document.getElementById('servico').value = tr.dataset.servico;
      document.getElementById('tipoServico').value = tr.dataset.tiposervico;
      document.getElementById('modalEditar').style.display = 'block';
    }

    function fecharModal() {
      document.getElementById('modalEditar').style.display = 'none';
    }

    window.onclick = function (event) {
      const modal = document.getElementById('modalEditar');
      if (event.target == modal) {
        fecharModal();
      }
    }

    function excluirAgendamento(id) {
      if (confirm('Deseja realmente excluir o agendamento ID ' + id + '?')) {
        alert("Agendamento " + id + " excluído (simulação).");
        // Aqui você poderia remover da DOM, como exemplo:
        const row = document.querySelector(`tr[data-id='${id}']`);
        if (row) row.remove();
      }
    }