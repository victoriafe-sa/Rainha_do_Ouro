<!DOCTYPE html>

<html lang="pt-br">

  <head>
    <meta charset="UTF-8">
    <title>Editar Funcionario</title>
    <link rel="stylesheet" href="css/estiloforms.css"/>
  </head>

  <body>
    <?php
      include("../conectarbd.php");
      $recid=filter_input(INPUT_GET, 'editarid');
      $selecionar= mysqli_query($conn, "SELECT * FROM tb_funcionarios WHERE id_funcionarios=$recid");
      $campo= mysqli_fetch_array($selecionar);
    ?>

    <div class="formulario">
      <form method="post" action="EditarFuncionario.php">
     
          <h1>Alterar Funcionario</h1>
     
<!esta linha cria um campo oculto para passar o id_evento, pois senão ao clicar em Salvar o código não saberá onde salvar.-->
<input type="hidden" name="id" value="<?=$campo["id"]?>"> 

<label>Nome completo</label><br> 
<input type="text" name="nome_completo" placeholder="Nome completo" value="<?=$campo["nome_completo"]?>"> <br><br>

<label>Data de nascimento</label><br>
<input type="date" name="data_nascimento" value="<?=$campo["data_nascimento"]?>"> <br><br>

<label>CPF</label><br>
<input type="text" name="cpf" placeholder="CPF" value="<?=$campo["cpf"]?>"> <br><br>

<label>RG</label><br>
<input type="text" name="rg" placeholder="RG" value="<?=$campo["rg"]?>"> <br><br>

<label>Sexo</label><br>
<input type="text" name="sexo" placeholder="Sexo" value="<?=$campo["sexo"]?>"> <br><br>

<label>Estado civil</label><br>
<input type="text" name="estado_civil" placeholder="Estado civil" value="<?=$campo["estado_civil"]?>"> <br><br>

<label>Telefone</label><br>
<input type="text" name="telefone" placeholder="Telefone" value="<?=$campo["telefone"]?>"> <br><br>

<label>Email</label><br>
<input type="email" name="email" placeholder="Email" value="<?=$campo["email"]?>"> <br><br>

<label>CEP</label><br>
<input type="text" name="cep" placeholder="CEP" value="<?=$campo["cep"]?>"> <br><br>

<label>Rua</label><br>
<input type="text" name="rua" placeholder="Rua" value="<?=$campo["rua"]?>"> <br><br>

<label>Número</label><br>
<input type="text" name="numero" placeholder="Número" value="<?=$campo["numero"]?>"> <br><br>

<label>Bairro</label><br>
<input type="text" name="bairro" placeholder="Bairro" value="<?=$campo["bairro"]?>"> <br><br>

<label>Cidade</label><br>
<input type="text" name="cidade" placeholder="Cidade" value="<?=$campo["cidade"]?>"> <br><br>

<label>Estado</label><br>
<input type="text" name="estado" placeholder="Estado" value="<?=$campo["estado"]?>"> <br><br>

<label>Cargo</label><br>
<input type="text" name="cargo" placeholder="Cargo" value="<?=$campo["cargo"]?>"> <br><br>

<label>Data de admissão</label><br>
<input type="date" name="data_admissao" value="<?=$campo["data_admissao"]?>"> <br><br>

<label>Horário de trabalho</label><br>
<input type="text" name="horario_trabalho" placeholder="Horário de trabalho" value="<?=$campo["horario_trabalho"]?>"> <br><br>

<label>Salário</label><br>
<input type="text" name="salario" placeholder="Salário" value="<?=$campo["salario"]?>"> <br><br>

<label>Tipo de contrato</label><br>
<input type="text" name="tipo_contrato" placeholder="Tipo de contrato" value="<?=$campo["tipo_contrato"]?>"> <br><br>

<label>Carteira de trabalho</label><br>
<input type="text" name="carteira_trabalho" placeholder="Carteira de trabalho" value="<?=$campo["carteira_trabalho"]?>"> <br><br>

<label>PIS</label><br>
<input type="text" name="pis" placeholder="PIS" value="<?=$campo["pis"]?>"> <br><br>

<label>Status</label><br>
<input type="text" name="status" placeholder="Status" value="<?=$campo["status"]?>"> <br><br>

<label>Observações</label><br>
<input type="text" name="observacoes" placeholder="Observações" value="<?=$campo["observacoes"]?>"> <br><br>

<label>Data de cadastro</label><br>
<input type="date" name="data_cadastro" value="<?=$campo["data_cadastro"]?>"> <br><br>

        <input type="submit" class="botoes" value="Salvar" >
        <a href="FormConsultarProduto.php"><input type="button" class="botoes" value="Cancelar"/></a>

      </form>
    </div>

  </body>
</html>
