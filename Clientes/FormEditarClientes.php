<!DOCTYPE html>

<html lang="pt-br">

  <head>
    <meta charset="UTF-8">
    <title>Editar Clientes</title>
    <link rel="stylesheet" href="css/estiloforms.css"/>
  </head>

  <body>
    <?php
      include("../conectarbd.php");
      $recid=filter_input(INPUT_GET, 'editarid');
      $selecionar= mysqli_query($conn, "SELECT * FROM tb_clientes WHERE id_clientes=$recid");
      $campo= mysqli_fetch_array($selecionar);
    ?>

    <div class="formulario">
      <form method="post" action="EditarCliente.php">
     
          <h1>Alterar Clientes</h1>
     
<!--esta linha cria um campo oculto para passar o id_clientes, pois senão ao clicar em Salvar o código não saberá onde salvar.-->
        <input type="hidden" name="id" value="<?=$campo["id_clientes"]?>">

        <label>Nome</label><br>
        <input type="text" name="nome" placeholder="Nome" value="<?=$campo["nome"]?>"> <br><br>
        
         <label>Telefone</label><br>
        <input type="text" name="telefone" placeholder="telefone" value="<?=$campo["telefone"]?>"> <br><br>
       
        <label>Data de Nascimento</label><br>
        <input type="text" name="data_nascimento" placeholder="data_nascimento" value="<?=$campo["data_nascimento"]?>"> <br><br>
        
        <label>Email</label><br>
        <input type="text" name="email" placeholder="email" value="<?=$campo["email"]?>"> <br><br>

        <label>Senha</label><br>
        <input type="text" name="senha" placeholder="senha" value="<?=$campo["senha"]?>"> <br><br>
   
        <label>CEP</label><br>
        <input type="text" name="cep" placeholder="cep" value="<?=$campo["cep"]?>"> <br><br>

        <label>Rua</label><br>
        <input type="text" name="rua" placeholder="rua" value="<?=$campo["rua"]?>"> <br><br>

        <label>Numero</label><br>
        <input type="text" name="numero" placeholder="numero" value="<?=$campo["numero"]?>"> <br><br>

        <label>Bairro</label><br>
        <input type="text" name="bairro" placeholder="bairro" value="<?=$campo["bairro"]?>"> <br><br>

        <label>Cidade</label><br>
        <input type="text" name="cidade" placeholder="cidade" value="<?=$campo["cidade"]?>"> <br><br>

        <label>Estado</label><br>
        <input type="text" name="estado" placeholder="estado" value="<?=$campo["estado"]?>"> <br><br>

        <label>Data de Cadastro</label><br>
        <input type="text" name="data_cadastro" placeholder="data_cadastro" value="<?=$campo["data_cadastro"]?>"> <br><br>

        <label>Ativo</label><br>
        <input type="text" name="ativo" placeholder="ativo" value="<?=$campo["ativo"]?>"> <br><br>
        
        <input type="submit" class="botoes" value="Salvar" >
        <a href="FormConsultarClientes.php"><input type="button" class="botoes" value="Cancelar"/></a>

      </form>
    </div>

  </body>
</html>
