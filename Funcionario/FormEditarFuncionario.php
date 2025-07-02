<!DOCTYPE html>

<html lang="pt-br">

  <head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="css/estiloforms.css"/>
  </head>

  <body>
    <?php
      include("../conectarbd.php");
      $recid=filter_input(INPUT_GET, 'editarid');
      $selecionar= mysqli_query($conn, "SELECT * FROM tb_produtos WHERE id_produtos=$recid");
      $campo= mysqli_fetch_array($selecionar);
    ?>

    <div class="formulario">
      <form method="post" action="EditarVenda.php">
     
          <h1>Alterar Produto</h1>
     
<!esta linha cria um campo oculto para passar o id_evento, pois senão ao clicar em Salvar o código não saberá onde salvar.-->
        <input type="hidden" name="id" value="<?=$campo["id_produtos"]?>"> 

        <label>Nome</label><br> 
        <input type="text" name="nome" placeholder="Nome" value="<?=$campo["nome"]?>"> <br><br>

        <label>Tipo</label><br>
        <input type="text" name="tipo" placeholder="tipo" value="<?=$campo["tipo"]?>"> <br><br>
        
        <label>valor de compra</label><br>
        <input type="text" name="valor_compra" placeholder="valor de compra" value="<?=$campo["valor_compra"]?>"> <br><br>
        
        <label>valor de vendas</label><br>
        <input type="text" name="valor_venda" placeholder="valor de venda" value="<?=$campo["valor_venda"]?>"> <br><br>
        
        <label>descrição:</label><br>
        <input type="text" name="descricao" placeholder="descricao" value="<?=$campo["descricao"]?>"> <br><br>


        <input type="submit" class="botoes" value="Salvar" >
        <a href="FormConsultarProduto.php"><input type="button" class="botoes" value="Cancelar"/></a>

      </form>
    </div>

  </body>
</html>
