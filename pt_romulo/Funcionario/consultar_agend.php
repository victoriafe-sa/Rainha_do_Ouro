<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rainhadoouro";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "
SELECT 
    ag.id_agendamentos,
    ag.data_hora,
    ag.status,
    func.nome_completo AS cabeleireiro,
    pag.valor,
    cli.nome AS cliente
FROM tb_agendamentos ag
INNER JOIN tb_funcionarios func ON func.id_funcionarios = ag.tb_funcionarios_id_funcionarios
INNER JOIN tb_pagamentos pag ON pag.id_pagamentos = ag.tb_pagamentos_id_pagamentos
INNER JOIN tb_clientes cli ON cli.id_clientes = pag.tb_clientes_id_clientes
ORDER BY ag.data_hora DESC
LIMIT 20;
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Agendamentos - Rainha do Ouro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* Reset básico */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #F8D39C;
      color: #4B2C1A;
      min-height: 100vh;
      padding: 30px 20px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    .container {
      width: 100%;
      max-width: 1280px;
      display: flex;
      flex-direction: column;
      align-items: center;
      background: #fff;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgb(75 44 26 / 0.2);
    }

    h1 {
      color: #4B2C1A;
      font-weight: 700;
      font-size: 2.2rem;
      margin-bottom: 25px;
      text-shadow: 0 0 7px #F0B42944;
      text-align: center;
    }

    .search-container {
      width: 100%;
      max-width: 600px;
      margin-bottom: 20px;
    }

    #searchInput {
      width: 100%;
      padding: 12px 18px;
      font-size: 1rem;
      border: 2px solid #4B2C1A;
      border-radius: 8px;
      outline-offset: 2px;
      transition: border-color 0.3s ease;
      box-shadow: inset 0 2px 5px rgb(75 44 26 / 0.1);
    }

    #searchInput:focus {
      border-color: #F0B429;
      outline: none;
      box-shadow: 0 0 8px #F0B429;
    }

    .table-wrapper {
      width: 100%;
      overflow-x: auto;
      box-shadow: 0 0 15px rgb(75 44 26 / 0.2);
      border-radius: 10px;
      background: #fff;
      padding: 20px;
    }

    table {
      border-collapse: separate;
      border-spacing: 0 12px;
      width: 100%;
      min-width: 1100px;
      font-size: 0.95rem;
    }

    thead tr {
      background-color: #4B2C1A;
      color: #F7E1A0;
      font-weight: 700;
      font-size: 0.95rem;
      border-radius: 10px 10px 0 0;
    }

    thead th {
      padding: 14px 18px;
      text-align: center;
      white-space: nowrap;
      user-select: none;
    }

    tbody tr {
      background: #fff;
      box-shadow: 0 2px 10px rgb(75 44 26 / 0.1);
      transition: background-color 0.3s ease, transform 0.2s ease;
      border-radius: 10px;
      cursor: default;
    }

    tbody tr:hover {
      background-color: #f7e6c2;
      transform: translateY(-3px);
    }

    tbody td {
      padding: 14px 10px;
      text-align: center;
      white-space: nowrap;
      color: #4B2C1A;
      border-bottom: 1px solid #f0d2a5;
      vertical-align: middle;
    }

    tbody tr:last-child td {
      border-bottom: none;
    }

    /* Status colorido */
    tbody td.status-agendado {
      color: #F0B429;
      font-weight: 600;
    }

    tbody td.status-realizado {
      color: #2E8B57;
      font-weight: 600;
    }

    tbody td.status-cancelado {
      color: #d9534f;
      font-weight: 600;
    }

    /* Botões de ação */
    .btn {
      border: none;
      cursor: pointer;
      font-weight: 600;
      border-radius: 6px;
      padding: 7px 14px;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      font-size: 0.9rem;
      user-select: none;
    }

    .btn.edit {
      background-color: #4B2C1A;
      color: #F7E1A0;
      box-shadow: 0 3px 6px rgb(75 44 26 / 0.3);
    }

    .btn.edit:hover {
      background-color: #3a2114;
      box-shadow: 0 6px 10px rgb(58 33 20 / 0.6);
    }

    .btn.delete {
      background-color: #d9534f;
      color: white;
      box-shadow: 0 3px 6px rgb(217 83 79 / 0.4);
    }

    .btn.delete:hover {
      background-color: #b43c3a;
      box-shadow: 0 6px 10px rgb(180 60 58 / 0.7);
    }

    /* Modal */
    .modal-content {
      background: white;
      border-radius: 12px;
      max-width: 400px;
      width: 90%;
      padding: 25px 30px;
      text-align: center;
      box-shadow: 0 0 20px rgb(75 44 26 / 0.3);
      border: none;
    }

    .modal-header {
      border-bottom: none;
      padding-bottom: 0;
      margin-bottom: 15px;
    }

    .modal-title {
      margin-bottom: 0;
      font-weight: 700;
      font-size: 1.5rem;
      color: #4B2C1A;
    }

    .btn-close {
      background: none;
      border: none;
      font-size: 1.5rem;
      opacity: 0.5;
      transition: opacity 0.3s ease;
    }

    .btn-close:hover {
      opacity: 1;
    }

    input.form-control,
    select.form-select {
      border-radius: 8px;
      border: 2px solid #4B2C1A;
      padding: 10px 15px;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      font-size: 1rem;
      color: #4B2C1A;
      background: #fff;
    }

    input.form-control:focus,
    select.form-select:focus {
      outline: none;
      border-color: #F0B429;
      box-shadow: 0 0 10px #F0B429;
    }

    .modal-footer {
      border-top: none;
      padding-top: 15px;
      display: flex;
      justify-content: flex-end;
      gap: 15px;
    }

    /* Responsividade */
    @media (max-width: 768px) {
      h1 {
        font-size: 1.8rem;
      }

      table {
        min-width: 800px;
      }
    }

    @media (max-width: 480px) {
      table {
        min-width: 700px;
      }

      .search-container {
        max-width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Agendamentos</h1>

    <div class="search-container">
      <input type="text" id="searchInput" placeholder="Filtrar por cliente, cabeleireiro, status ou data..." />
    </div>

    <div class="table-wrapper">
      <?php if (!$result) : ?>
        <div class="alert alert-danger">Erro na consulta: <?= htmlspecialchars($conn->error) ?></div>
      <?php elseif ($result->num_rows === 0) : ?>
        <div class="alert alert-warning">Nenhum agendamento encontrado.</div>
      <?php else : ?>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Cliente</th>
              <th>Cabeleireiro</th>
              <th>Data e Hora</th>
              <th>Status</th>
              <th>Valor</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody id="appointmentsTable">
            <?php while ($row = $result->fetch_assoc()) :
              $statusClass = 'status-' . strtolower($row['status']);
            ?>
              <tr>
                <td><?= $row['id_agendamentos'] ?></td>
                <td><?= htmlspecialchars($row['cliente']) ?></td>
                <td><?= htmlspecialchars($row['cabeleireiro']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($row['data_hora'])) ?></td>
                <td class="<?= $statusClass ?>"><?= ucfirst(htmlspecialchars($row['status'])) ?></td>
                <td>R$ <?= number_format($row['valor'], 2, ',', '.') ?></td>
                <td>
                  <button class="btn edit" onclick="editar(<?= $row['id_agendamentos'] ?>)" title="Editar">
                    ✏️ Editar
                  </button>
                  <button class="btn delete" onclick="excluir(<?= $row['id_agendamentos'] ?>)" title="Excluir">
                    🗑️ Excluir
                  </button>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="formEditar" method="POST" action="editar_agendamento.php">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditarLabel">Editar Agendamento</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id_agendamento" id="editId" />
              <div class="mb-3 text-start">
                <label for="editCliente" class="form-label">Cliente</label>
                <input type="text" class="form-control" id="editCliente" name="cliente" readonly />
              </div>
              <div class="mb-3 text-start">
                <label for="editCabeleireiro" class="form-label">Cabeleireiro</label>
                <input type="text" class="form-control" id="editCabeleireiro" name="cabeleireiro" readonly />
              </div>
              <div class="mb-3 text-start">
                <label for="editDataHora" class="form-label">Data e Hora</label>
                <input type="datetime-local" class="form-control" id="editDataHora" name="data_hora" required />
              </div>
              <div class="mb-3 text-start">
                <label for="editStatus" class="form-label">Status</label>
                <select class="form-select" id="editStatus" name="status" required>
                  <option value="agendado">Agendado</option>
                  <option value="realizado">Realizado</option>
                  <option value="cancelado">Cancelado</option>
                </select>
              </div>
              <div class="mb-3 text-start">
                <label for="editValor" class="form-label">Valor (R$)</label>
                <input type="number" step="0.01" class="form-control" id="editValor" name="valor" required />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn edit btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn edit">Salvar Alterações</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Filtro da tabela
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

    // Função para abrir modal e preencher dados para editar
    function editar(id) {
      const row = [...document.querySelectorAll('#appointmentsTable tr')].find(r => r.children[0].textContent == id);
      if (!row) return alert('Agendamento não encontrado.');

      document.getElementById('editId').value = id;
      document.getElementById('editCliente').value = row.children[1].textContent;
      document.getElementById('editCabeleireiro').value = row.children[2].textContent;

      let dataHora = row.children[3].textContent.split(' ');
      let data = dataHora[0].split('/');
      let hora = dataHora[1];
      let dataFormatada = `${data[2]}-${data[1].padStart(2, '0')}-${data[0].padStart(2, '0')}T${hora}`;
      document.getElementById('editDataHora').value = dataFormatada;

      document.getElementById('editStatus').value = row.children[4].textContent.toLowerCase();
      let valor = row.children[5].textContent.replace('R$', '').replace('.', '').replace(',', '.').trim();
      document.getElementById('editValor').value = parseFloat(valor);

      let modal = new bootstrap.Modal(document.getElementById('modalEditar'));
      modal.show();
    }

    // Função para excluir com confirmação
    function excluir(id) {
      if (confirm(`Deseja realmente excluir o agendamento ID ${id}?`)) {
        window.location.href = `excluir_agendamento.php?id=${id}`;
      }
    }
  </script>
</body>

</html>
