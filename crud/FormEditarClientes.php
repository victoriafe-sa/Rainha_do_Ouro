<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Clientes</title>
    <link rel="stylesheet" href="../css/editar.css"/>
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
</head>

<body>
    <?php
        include("../conectarbd.php");
        $recid = filter_input(INPUT_GET, 'editarid');
        $selecionar = mysqli_query($conn, "SELECT * FROM tb_clientes WHERE id_clientes=$recid");
        $campo = mysqli_fetch_array($selecionar);
    ?>

        <div class="formulario">
            <h1>Editar Clientes</h1>
            <form method="post" action="EditarCliente.php">
                <input type="hidden" name="id" value="<?=$campo["id_clientes"]?>">

                <label>Nome</label>
                <input type="text" name="nome" placeholder="Nome" value="<?=$campo["nome"]?>">

                <label>Telefone</label>
                <input type="text" name="telefone" placeholder="Telefone" value="<?=$campo["telefone"]?>">

                <label>Data de Nascimento</label>
                <input type="text" name="data_nascimento" placeholder="Data de nascimento" value="<?=$campo["data_nascimento"]?>">

                <label>Email</label>
                <input type="text" name="email" placeholder="Email" value="<?=$campo["email"]?>">

                <label>Senha</label>
                <input type="text" name="senha" placeholder="Senha" value="<?=$campo["senha"]?>">

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

                <label>Ativo</label>
                <input class="form-input" type="text" name="ativo" placeholder="Ativo" value="<?=$campo["ativo"]?>">

                <input type="submit" class="botoes" value="Salvar">
                <a href="FormConsultarClientes.php"><button type="button" class="botoes">Cancelar</button></a>
            </form>
        </div>

</body>
</html>
