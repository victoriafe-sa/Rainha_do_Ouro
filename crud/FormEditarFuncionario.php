<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Funcionário</title>
    <link rel="stylesheet" href="../css/editar.css" />
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
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

            <h1>Editar Funcionário</h1>

            <input type="hidden" name="id" value="<?=$campo["id_funcionarios"]?>">

            <label>Nome completo</label>
            <input type="text" name="nome_completo" placeholder="Nome completo" value="<?=$campo["nome_completo"]?>">
          

            <label>Data de nascimento</label>
            <input type="date" name="data_nascimento" value="<?=$campo["data_nascimento"]?>">

            <label>CPF</label>
            <input type="text" name="cpf" placeholder="CPF" value="<?=$campo["cpf"]?>">

            <label>RG</label>
            <input type="text" name="rg" placeholder="RG" value="<?=$campo["rg"]?>">

            <label>Sexo</label>
            <input type="text" name="sexo" placeholder="Sexo" value="<?=$campo["sexo"]?>">

            <label>Estado civil</label>
            <input type="text" name="estado_civil" placeholder="Estado civil" value="<?=$campo["estado_civil"]?>">
          

            <label>Telefone</label>
            <input type="text" name="telefone" placeholder="Telefone" value="<?=$campo["telefone"]?>">

            <label>Email</label>
            <input type="email" name="email" placeholder="Email" value="<?=$campo["email"]?>">

            <label>CEP</label>
            <input type="text" name="cep" placeholder="CEP" value="<?=$campo["cep"]?>">

            <label>Rua</label>
            <input type="text" name="rua" placeholder="Rua" value="<?=$campo["rua"]?>">

            <label>Número</label>
            <input type="text" name="numero" placeholder="Número" value="<?=$campo["numero"]?>">

            <label>Bairro</label>
            <input type="text" name="bairro" placeholder="Bairro" value="<?=$campo["bairro"]?>">

            <label>Cidade</label>
            <input type="text" name="cidade" placeholder="Cidade" value="<?=$campo["cidade"]?>">

            <label>Estado</label>
            <input type="text" name="estado" placeholder="Estado" value="<?=$campo["estado"]?>">

            <label>Cargo</label>
            <input type="text" name="cargo" placeholder="Cargo" value="<?=$campo["cargo"]?>">

            <label>Horário de trabalho</label>
            <input type="text" name="horario_trabalho" placeholder="Horário de trabalho"
                value="<?=$campo["horario_trabalho"]?>">

            <label>Salário</label>
            <input type="text" name="salario" placeholder="Salário" value="<?=$campo["salario"]?>">

            <label>Tipo de contrato</label>
            <input type="text" name="tipo_contrato" placeholder="Tipo de contrato" value="<?=$campo["tipo_contrato"]?>">
          

            <label>Carteira de trabalho</label>
            <input type="text" name="carteira_trabalho" placeholder="Carteira de trabalho"
                value="<?=$campo["carteira_trabalho"]?>">

            <label>PIS</label>
            <input type="text" name="pis" placeholder="PIS" value="<?=$campo["pis"]?>">

            <label>Status</label>
            <input type="text" name="status" placeholder="Status" value="<?=$campo["status"]?>">

            <label>Observações</label>
            <input type="text" name="observacoes" placeholder="Observações" value="<?=$campo["observacoes"]?>">

            <input type="submit" class="botoes" value="Salvar">
            <a href="FormConsultarFuncionario.php"><input type="button" class="botoes" value="Cancelar" /></a>

        </form>
    </div>

</body>

</html>