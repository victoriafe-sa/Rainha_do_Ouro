<?php

include("../conectarbd.php");
$recid= filter_input(INPUT_GET, 'servico');

  if(mysqli_query($conn, "DELETE FROM tb_servicos WHERE id_servicos=$recid")) {
    echo "<script>alert('Dados excluidos com sucesso!'); window.location = 'FormConsultarServico.php';</script>";
  }else {
    echo "Não foi possível excluir os dados no Banco de Dados" . $recid . "<br>" . mysqli_error($conn);
  }
  mysqli_close($conn);

?>