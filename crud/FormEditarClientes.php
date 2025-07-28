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

    <div class="payment-tabs">
        <div class="form-container">
            <h1>Editar Clientes</h1>
            <form method="post" action="EditarCliente.php">
                <input type="hidden" name="id" value="<?=$campo["id_clientes"]?>">

                <label class="form-label">Nome</label>
                <input class="form-input" type="text" name="nome" placeholder="Nome" value="<?=$campo["nome"]?>">

                <label class="form-label">Telefone</label>
                <input class="form-input" type="text" name="telefone" placeholder="Telefone" value="<?=$campo["telefone"]?>">

                <label class="form-label">Data de Nascimento</label>
                <input class="form-input" type="text" name="data_nascimento" placeholder="Data de nascimento" value="<?=$campo["data_nascimento"]?>">

                <label class="form-label">Email</label>
                <input class="form-input" type="text" name="email" placeholder="Email" value="<?=$campo["email"]?>">

                <label class="form-label">Senha</label>
                <input class="form-input" type="text" name="senha" placeholder="Senha" value="<?=$campo["senha"]?>">

                <label class="form-label">CEP</label>
                <input class="form-input" type="text" name="cep" placeholder="CEP" value="<?=$campo["cep"]?>">

                <label class="form-label">Rua</label>
                <input class="form-input" type="text" name="rua" placeholder="Rua" value="<?=$campo["rua"]?>">

                <label class="form-label">Número</label>
                <input class="form-input" type="text" name="numero" placeholder="Número" value="<?=$campo["numero"]?>">

                <label class="form-label">Bairro</label>
                <input class="form-input" type="text" name="bairro" placeholder="Bairro" value="<?=$campo["bairro"]?>">

                <label class="form-label">Cidade</label>
                <input class="form-input" type="text" name="cidade" placeholder="Cidade" value="<?=$campo["cidade"]?>">

                <label class="form-label">Estado</label>
                <input class="form-input" type="text" name="estado" placeholder="Estado" value="<?=$campo["estado"]?>">

                <label class="form-label">Data de Cadastro</label>
                <input class="form-input" type="text" name="data_cadastro" placeholder="Data de cadastro" value="<?=$campo["data_cadastro"]?>">

                <label class="form-label">Ativo</label>
                <input class="form-input" type="text" name="ativo" placeholder="Ativo" value="<?=$campo["ativo"]?>">

                <input type="submit" class="btn" value="Salvar">
                <a href="FormConsultarClientes.php"><button type="button" class="btn">Cancelar</button></a>
            </form>
        </div>
    </div>

</body>
</html>
