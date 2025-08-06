<?php
session_start();

if (!isset($_SESSION['id_cliente'])) {
    echo '<tr><td colspan="7" class="text-danger text-center">Sessão expirada. Faça login novamente.</td></tr>';
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
?>
