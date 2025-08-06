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

// Se for funcionário, pode visualizar tudo (sem filtro)
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

// Se tem filtro por cliente, acrescenta WHERE
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

if (!$result) {
    echo '<tr><td colspan="7" class="text-danger text-center">Erro ao buscar agendamentos.</td></tr>';
    exit;
}

if ($result->num_rows === 0) {
    echo '<tr><td colspan="7" class="text-warning text-center">Nenhum agendamento encontrado.</td></tr>';
    exit;
}

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
      <td>
        <button class=\"btn btn-sm btn-primary\" onclick=\"abrirModalEditar(this)\">✏️ Editar</button>
        <button class=\"btn btn-sm btn-danger\" onclick=\"excluirAgendamento({$row['id_agendamentos']})\">🗑️ Excluir</button>
      </td>
    </tr>
    ";
}
