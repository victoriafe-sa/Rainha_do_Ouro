<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

include("../conectarbd.php");

// Variável para filtro, default sem filtro
$id_cliente_filtro = null;

// Se for cliente logado, usa o id_cliente da sessão
if (isset($_SESSION['id_cliente'])) {
    $id_cliente_filtro = $_SESSION['id_cliente'];
}

// Monta a query base
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
";

// Aplica filtro por cliente, se existir
if ($id_cliente_filtro !== null) {
    $sql .= " WHERE ag.tb_clientes_id_clientes = ? ";
}

$sql .= " ORDER BY ag.data DESC, ag.horario DESC LIMIT 50";

$stmt = $conn->prepare($sql);

if ($id_cliente_filtro !== null) {
    $stmt->bind_param("i", $id_cliente_filtro);
}

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
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 400px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    .close-btn {
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        border: none;
        background: none;
    }

    /* Exemplo simples para status */
    .status-agendado {
        color: blue;
        font-weight: bold;
    }

    .status-realizado {
        color: green;
        font-weight: bold;
    }

    .status-cancelado {
        color: red;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h1>Agendamentos</h1>

        <div class="search-container mb-3">
            <input type="text" id="searchInput" class="form-control"
                placeholder="Filtrar por cliente, status, serviço ou data..." />
        </div>

        <div class="table-wrapper">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Status</th>
                        <th>Serviço</th>
                        <th>Tipo de Serviço</th>
                    </tr>
                </thead>
                <tbody id="appointmentsTable">
                    <?php
          if (!$result) {
              echo '<tr><td colspan="7" class="text-danger text-center">Erro ao buscar agendamentos.</td></tr>';
          } elseif ($result->num_rows === 0) {
              echo '<tr><td colspan="7" class="text-warning text-center">Nenhum agendamento encontrado.</td></tr>';
          } else {
              while ($row = $result->fetch_assoc()) {
                  $statusClass = 'status-' . strtolower($row['status']);
                  $nome_cliente = htmlspecialchars($row['nome_cliente'] ?? 'Desconhecido');
                  $data_formatada = date('d/m/Y', strtotime($row['data']));
                  $hora_formatada = date('H:i', strtotime($row['horario']));
                  $servico = htmlspecialchars($row['servico'], ENT_QUOTES);
                  $tipo = htmlspecialchars($row['tipoServico'], ENT_QUOTES);
                  $status = ucfirst(htmlspecialchars($row['status']));
                  
                  echo "
                  <tr data-id=\"{$row['id_agendamentos']}\"
                      data-data=\"{$row['data']}\"
                      data-horario=\"{$row['horario']}\"
                      data-status=\"{$row['status']}\"
                      data-servico=\"{$servico}\"
                      data-tiposervico=\"{$tipo}\">
                    <td>{$nome_cliente}</td>
                    <td>{$data_formatada}</td>
                    <td>{$hora_formatada}</td>
                    <td class=\"{$statusClass}\">{$status}</td>
                    <td>{$servico}</td>
                    <td>{$tipo}</td>
                  </tr>
                  ";
              }
          }
          ?>
                </tbody>
            </table>
        </div>
        <div class="buttonBack">
        <button type="cancel"><a href="../html/dashboard_cabeleireira.php">Cancelar</a> </button>
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
    </script>

</body>

</html>