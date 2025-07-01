<?php

include("../conectarbd.php");
$recid= filter_input(INPUT_POST, 'id');
$recnome= filter_input(INPUT_POST, 'nome');
$recdescricao= filter_input(INPUT_POST, 'descricao');
$recpreco_venda= filter_input(INPUT_POST, 'preco_venda');
$reccategoria= filter_input(INPUT_POST, 'categoria');
$recativo= filter_input(INPUT_POST, 'ativo');
$recemail= filter_input(INPUT_POST, 'email');

  if(mysqli_query($conn, "UPDATE tb_produtos SET nome='$recnome', descricao='$recdescricao',preco_venda='$recrpreco_venda',categoria='$reccategoria',ativo='$recativo'  WHERE id_produtos=$recid")) {
    echo "<script>alert('Dados alterado com sucesso!'); window.location = 'FormConsultarProduto.php';</script>";
   }else {
    echo "Não foi possível alterar os dados no Banco de Dados" . $recid . "<br>" . mysqli_error($conn);
  }
  mysqli_close($conn);

?>