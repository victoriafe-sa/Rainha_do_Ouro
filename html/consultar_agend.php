<?php
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
ORDER BY ag.data DESC, ag.horario DESC
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
  <link href="../css/consultarAgendamento.css" rel="stylesheet" />
  <style>
    /* seu CSS aqui igual antes, omitido para brevidade */
  </style>
</head>

<body>
  <div class="container">
    <h1>Agendamentos</h1>

    <div class="search-container">
      <input type="text" id="searchInput" placeholder="Filtrar por cliente, status, serviço ou data..." />
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
              <tr>
                <td><?= htmlspecialchars($row['nome_cliente'] ?? 'Desconhecido') ?></td>
                <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                <td><?= date('H:i', strtotime($row['horario'])) ?></td>
                <td class="<?= $statusClass ?>"><?= ucfirst(htmlspecialchars($row['status'])) ?></td>
                <td><?= htmlspecialchars($row['servico']) ?></td>
                <td><?= htmlspecialchars($row['tipoServico']) ?></td>
                <td>
                  <button class="btn edit" onclick="editar(<?= $row['id_agendamentos'] ?>)" title="Editar">✏️ Editar</button>
                  <button class="btn delete" onclick="excluir(<?= $row['id_agendamentos'] ?>)" title="Excluir">🗑️ Excluir</button>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

  <script>
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

    function editar(id) {
      alert('Aqui você pode abrir modal para editar o agendamento ID ' + id);
    }

    function excluir(id) {
      if (confirm('Deseja realmente excluir o agendamento ID ' + id + '?')) {
        window.location.href = 'excluir_agendamento.php?id=' + id;
      }
    }
  </script>
</body>

</html>
