<?php

include("../conectarbd.php");
$recid= filter_input(INPUT_POST, 'id');
$recnome= filter_input(INPUT_POST, 'nome');
$recdescricao= filter_input(INPUT_POST, 'descricao');
$recpreco= filter_input(INPUT_POST, 'preco');
$recduracao_min= filter_input(INPUT_POST, 'duracao_min');
$recativo= filter_input(INPUT_POST, 'ativo');

  if(mysqli_query($conn, "UPDATE tb_servicos SET nome='$recnome', descricao='$recdescricao',preco='$recpreco',duracao_min='$recduracao_min',ativo='$recativo'  WHERE id_servicos=$recid")) {
    echo "<script>alert('Dados alterado com sucesso!'); window.location = '../crud/FormConsultarServico.php';</script>";
   }else {
    echo "Não foi possível alterar os dados no Banco de Dados" . $recid . "<br>" . mysqli_error($conn);
  }
  mysqli_close($conn);

?>