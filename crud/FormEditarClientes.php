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
                <input type="text" name="nome" placeholder="Nome" value="<?=$campo["nome"]?>" required>

                <label>Telefone</label>
                <input type="text" name="telefone" placeholder="Telefone" value="<?=$campo["telefone"]?>" required>

                <label>Data de Nascimento</label>
                <input type="text" name="data_nascimento" placeholder="Data de nascimento" value="<?=$campo["data_nascimento"]?>" required>

                <label>Email</label>
                <input type="text" name="email" placeholder="Email" value="<?=$campo["email"]?>" required>

                <label>Senha</label>
                <input type="text" name="senha" placeholder="Senha" value="<?=$campo["senha"]?>" required>

                <label>CEP</label>
                <input type="number" name="cep" placeholder="CEP" value="<?=$campo["cep"]?>" required>

                <label>Rua</label>
                <input type="text" name="rua" placeholder="Rua" value="<?=$campo["rua"]?>" required>

                <label>Número</label>
                <input type="number" name="numero" placeholder="Número" value="<?=$campo["numero"]?>" required>

                <label>Bairro</label>
                <input type="text" name="bairro" placeholder="Bairro" value="<?=$campo["bairro"]?>" required>

                <label>Cidade</label>
                <input type="text" name="cidade" placeholder="Cidade" value="<?=$campo["cidade"]?>" required>

                <label>Estado</label>
                <input type="text" name="estado" placeholder="Estado" value="<?=$campo["estado"]?>" required>

                <label>Ativo</label>
                <input class="form-input" type="number" name="ativo" placeholder="Ativo" value="<?=$campo["ativo"]?>" required>

                <input type="submit" class="botoes" value="Salvar">
                <a href="../crud/FormConsultarClientes.php"><button type="button" class="botoes">Cancelar</button></a>
            </form>
        </div>

</body>
</html>
