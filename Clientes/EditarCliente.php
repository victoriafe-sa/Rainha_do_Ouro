<?php

include("../conectarbd.php");
$recid= filter_input(INPUT_POST, 'id');
$recnome= filter_input(INPUT_POST, 'nome');
$rectelefone= filter_input(INPUT_POST, 'telefone');
$recdata_nascimento= filter_input(INPUT_POST, 'data_nascimento');
$recemail= filter_input(INPUT_POST, 'email');
$recsenha= filter_input(INPUT_POST, 'senha');
$reccep= filter_input(INPUT_POST, 'cep');
$recrua= filter_input(INPUT_POST, 'rua');
$recnumero= filter_input(type: INPUT_POST, var_name: 'numero');
$recbairro= filter_input(type: INPUT_POST, var_name: 'bairro');
$reccidade= filter_input(type: INPUT_POST, var_name: 'cidade');
$recestado = filter_input(type: INPUT_POST, var_name: 'estado');
$recdata_cadastro = filter_input(type: INPUT_POST, var_name: 'data_cadastro');
$recativo = filter_input(type: INPUT_POST, var_name: 'ativo');

  if(mysqli_query($conn, "UPDATE tb_clientes SET nome='$recnome', telefone='$rectelefone', data_nascimento='$recdata_nascimento', email='$recemail', senha='$recsenha', 
  cep='$reccep',  rua='$recrua', numero='$recnumero', bairro='$recbairro', cidade='$reccidade', estado='$recestado', data_cadastro='$recdata_cadastro', ativo='$recativo' WHERE id_clientes=$recid")) {
    echo "<script>alert('Dados alterado com sucesso!'); window.location = 'FormConsultarClientes.php';</script>";
  }else {
    echo "Não foi possível alterar os dados no Banco de Dados" . $recid . "<br>" . mysqli_error($conn);
  }
  mysqli_close($conn);

?>