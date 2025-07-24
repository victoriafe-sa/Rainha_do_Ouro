<?php

include("../conectarbd.php");
$recid = filter_input(INPUT_POST, 'id');
$nome_completo = filter_input(INPUT_POST, 'nome_completo');
$data_nascimento = filter_input(INPUT_POST, 'data_nascimento');
$cpf = filter_input(INPUT_POST, 'cpf');
$rg = filter_input(INPUT_POST, 'rg');
$sexo = filter_input(INPUT_POST, 'sexo');
$estado_civil = filter_input(INPUT_POST, 'estado_civil');
$telefone = filter_input(INPUT_POST, 'telefone');
$email = filter_input(INPUT_POST, 'email');
$cep = filter_input(INPUT_POST, 'cep');
$rua = filter_input(INPUT_POST, 'rua');
$numero = filter_input(INPUT_POST, 'numero');
$bairro = filter_input(INPUT_POST, 'bairro');
$cidade = filter_input(INPUT_POST, 'cidade');
$estado = filter_input(INPUT_POST, 'estado');
$cargo = filter_input(INPUT_POST, 'cargo');
$horario_trabalho = filter_input(INPUT_POST, 'horario_trabalho');
$salario = filter_input(INPUT_POST, 'salario');
$tipo_contrato = filter_input(INPUT_POST, 'tipo_contrato');
$carteira_trabalho = filter_input(INPUT_POST, 'carteira_trabalho');
$pis = filter_input(INPUT_POST, 'pis');
$status = filter_input(INPUT_POST, 'status');
$observacoes = filter_input(INPUT_POST, 'observacoes');

  if(mysqli_query($conn, "UPDATE tb_funcionarios SET nome_completo='$nome_completo',
  data_nascimento='$data_nascimento',
  cpf='$cpf',
  rg='$rg',
  sexo='$sexo',
  estado_civil='$estado_civil',
  telefone='$telefone',
  email='$email',
  cep='$cep',
  rua='$rua',
  numero='$numero',
  bairro='$bairro',
  cidade='$cidade',
  estado='$estado',
  cargo='$cargo',
  horario_trabalho='$horario_trabalho',
  salario='$salario',
  tipo_contrato='$tipo_contrato',
  carteira_trabalho='$carteira_trabalho',
  pis='$pis',
  status='$status',
  observacoes='$observacoes' WHERE id_funcionarios=$recid")) {
    echo "<script>alert('Dados alterado com sucesso!'); window.location = 'FormConsultarFuncionario.php';</script>";
  }else {
    echo "Não foi possível alterar os dados no Banco de Dados" . $recid . "<br>" . mysqli_error($conn);
  }
  mysqli_close($conn);

?>