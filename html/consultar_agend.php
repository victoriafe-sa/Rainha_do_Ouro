<?php

session_start();

if (!isset($_SESSION['id_cliente'])) {
    header('Location: ../html/login.php');
    exit;
}

$id_cliente_logado = $_SESSION['id_cliente'];

include("../conectarbd.php");

$sql = "
SELECT 
    ag.id_agendamentos,
    ag.data,
    ag.horario,
    ag.status,
    ag.servico,
    ag.tipoServico,
    cli.nome AS nome_cliente
FROM tb_agendamentos ag
LEFT JOIN tb_clientes cli ON cli.id_clientes = ag.tb_clientes_id_clientes
WHERE ag.tb_clientes_id_clientes = ?
ORDER BY ag.data DESC, ag.horario DESC
LIMIT 20;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_cliente_logado);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Agendamentos - Rainha do Ouro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../css/consultarAgendamento.css" rel="stylesheet" />
  <style>
    /* Modal Styles */
    .modal {
      display: none; 
      position: fixed; 
      z-index: 9999; 
      left: 0; top: 0; width: 100%; height: 100%; 
      overflow: auto; 
      background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
      background-color: #fff;
      margin: 10% auto; 
      padding: 20px;
      border-radius: 8px;
      width: 400px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      position: relative;
    }
    .close-btn {
      position: absolute;
      right: 10px; top: 10px;
      font-size: 24px;
      font-weight: bold;
      cursor: pointer;
      border: none;
      background: none;
    }
  </style>
</head>
<body>
  <div class="container mt-4">
    <h1>Agendamentos</h1>

    <div class="search-container mb-3">
      <input type="text" id="searchInput" class="form-control" placeholder="Filtrar por cliente, status, serviço ou data..." />
    </div>

    <div class="table-wrapper">
      <?php if (!$result) : ?>
        <div class="alert alert-danger">Erro na consulta: <?= htmlspecialchars($conn->error) ?></div>
      <?php elseif ($result->num_rows === 0) : ?>
        <div class="alert alert-warning">Nenhum agendamento encontrado.</div>
      <?php else : ?>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Cliente</th>
              <th>Data</th>
              <th>Horário</th>
              <th>Status</th>
              <th>Serviço</th>
              <th>Tipo de Serviço</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody id="appointmentsTable">
            <?php while ($row = $result->fetch_assoc()) :
              $statusClass = 'status-' . strtolower($row['status']);
            ?>
              <tr data-id="<?= $row['id_agendamentos'] ?>" data-data="<?= $row['data'] ?>" data-horario="<?= $row['horario'] ?>" data-status="<?= $row['status'] ?>" data-servico="<?= htmlspecialchars($row['servico'], ENT_QUOTES) ?>" data-tiposervico="<?= htmlspecialchars($row['tipoServico'], ENT_QUOTES) ?>">
                <td><?= htmlspecialchars($row['nome_cliente'] ?? 'Desconhecido') ?></td>
                <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                <td><?= date('H:i', strtotime($row['horario'])) ?></td>
                <td class="<?= $statusClass ?>"><?= ucfirst(htmlspecialchars($row['status'])) ?></td>
                <td><?= htmlspecialchars($row['servico']) ?></td>
                <td><?= htmlspecialchars($row['tipoServico']) ?></td>
                <td>
                  <button class="btn btn-sm btn-primary" onclick="abrirModalEditar(this)">✏️ Editar</button>
                  <button class="btn btn-sm btn-danger" onclick="excluirAgendamento(<?= $row['id_agendamentos'] ?>)">🗑️ Excluir</button>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

  <!-- Modal Editar Agendamento -->
  <div id="modalEditar" class="modal">
    <div class="modal-content">
      <button class="close-btn" onclick="fecharModal()">&times;</button>
      <h4>Editar Agendamento</h4>
      <form id="formEditar" method="POST" action="editar_agendamento.php">
        <input type="hidden" name="id_agendamento" id="id_agendamento" />
        <div class="mb-3">
          <label for="data" class="form-label">Data</label>
          <input type="date" name="data" id="data" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="horario" class="form-label">Horário</label>
          <input type="time" name="horario" id="horario" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select name="status" id="status" class="form-select" required>
            <option value="agendado">Agendado</option>
            <option value="realizado">Realizado</option>
            <option value="cancelado">Cancelado</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="servico" class="form-label">Serviço</label>
          <input type="text" name="servico" id="servico" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="tipoServico" class="form-label">Tipo de Serviço</label>
          <input type="text" name="tipoServico" id="tipoServico" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-success">Salvar Alterações</button>
      </form>
    </div>
  </div>

  <script>
    // Filtrar tabela
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

    // Abrir modal preenchido
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

    // Fechar modal
    function fecharModal() {
      document.getElementById('modalEditar').style.display = 'none';
    }

    // Fechar modal ao clicar fora
    window.onclick = function(event) {
      const modal = document.getElementById('modalEditar');
      if (event.target == modal) {
        fecharModal();
      }
    }

    // Excluir agendamento
    function excluirAgendamento(id) {
      if (confirm('Deseja realmente excluir o agendamento ID ' + id + '?')) {
        window.location.href = 'excluir_agendamento.php?id=' + id;
      }
    }
  </script>
</body>
</html>
