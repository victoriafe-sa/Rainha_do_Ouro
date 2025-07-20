<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_rainhadoouro';

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Captura os filtros
$nome = $_GET['nome'] ?? '';
$cargo = $_GET['cargo'] ?? '';
$departamento = $_GET['departamento'] ?? 'todos';
$status = $_GET['status'] ?? 'todos';
$dataDe = $_GET['dataAdmissaoDe'] ?? '';
$dataAte = $_GET['dataAdmissaoAte'] ?? '';

// Monta a query
$query = "SELECT * FROM tb_funcionarios WHERE 1=1";

if ($nome !== '') {
    $query .= " AND nome_completo LIKE '%" . $conn->real_escape_string($nome) . "%'";
}

if ($cargo !== '') {
    $query .= " AND cargo LIKE '%" . $conn->real_escape_string($cargo) . "%'";
}

if ($departamento !== 'todos') {
    $query .= " AND departamento = '" . $conn->real_escape_string($departamento) . "'";
}

if ($status !== 'todos') {
    $query .= " AND status = '" . $conn->real_escape_string($status) . "'";
}

if ($dataDe !== '') {
    $query .= " AND data_admissao >= '" . $conn->real_escape_string($dataDe) . "'";
}

if ($dataAte !== '') {
    $query .= " AND data_admissao <= '" . $conn->real_escape_string($dataAte) . "'";
}

$resultado = $conn->query($query);

$funcionarios = [];
while ($row = $resultado->fetch_assoc()) {
    $funcionarios[] = $row;
}

header('Content-Type: application/json');
echo json_encode($funcionarios);
?>
