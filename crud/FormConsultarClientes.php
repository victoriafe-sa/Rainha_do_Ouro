<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Consultar Clientes</title>
    <link type="text/css" rel="stylesheet" href="../css/consultar.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
</head>

<body>
    <h1>Clientes Cadastrados</h1>
<!--Seção de pesquisa-->
    <form method="GET" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" />

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" />

        <label for="ativo">Ativo:</label>
        <select name="ativo" id="ativo">
            <option value="">Todos</option>
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>

        <input type="submit" value="Pesquisar" class="botoes" />
    </form>
    <br>

    <table width="100%" border="1" bordercolor="black" cellspacing="2" cellpadding="5">
        <tr>
            <td align="center"> <strong>ID</strong></td>
            <td align="center"> <strong>Nome</strong></td>
            <td align="center"> <strong>Telefone</strong></td>
            <td align="center"> <strong>CPF</strong></td>
            <td align="center"> <strong>Data de Nascimento</strong></td>
            <td align="center"> <strong>Email</strong></td>
            <td align="center"> <strong>Senha</strong></td>
            <td align="center"> <strong>Bairro</strong></td>
            <td align="center"> <strong>Cidade</strong></td>
            <td align="center"> <strong>Estado</strong></td>
            <td align="center"> <strong>Ativo</strong></td>
            <td align="center"> <strong>Editar</strong></td>
            <td align="center"> <strong>Excluir</strong></td>


        </tr>

        <?php
        include("../conectarbd.php");
        //$selecionar = mysqli_query($conn, "SELECT * FROM tb_clientes");

        $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
        $cpf = isset($_GET['cpf']) ? $_GET['cpf'] : '';
        $ativo = isset($_GET['ativo']) ? $_GET['ativo'] : '';

        // Monta a consulta SQL com filtros opcionais
        $sql = "SELECT * FROM tb_clientes WHERE 1=1";

        if (!empty($nome)) {
            $sql .= " AND nome LIKE '%" . mysqli_real_escape_string($conn, $nome) . "%'";
        }
        if (!empty($cpf)) {
            $sql .= " AND cpf LIKE '%" . mysqli_real_escape_string($conn, $cpf) . "%'";
        }
        if ($ativo !== '') {
            $sql .= " AND ativo = '" . mysqli_real_escape_string($conn, $ativo) . "'";
        }

        $selecionar = mysqli_query($conn, $sql);

        while ($campo = mysqli_fetch_array($selecionar)) { ?>
            <tr>
                <td align="center"><?= $campo["id_clientes"] ?></td>
                <td align="center"><?= $campo["nome"] ?></td>
                <td align="center"><?= $campo["telefone"] ?></td>
                <td align="center"><?= $campo["cpf"] ?></td>
                <td align="center"><?= $campo["data_nascimento"] ?></td>
                <td align="center"><?= $campo["email"] ?></td>
                <td align="center"><?= $campo["senha"] ?></td>
                <td align="center"><?= $campo["bairro"] ?></td>
                <td align="center"><?= $campo["cidade"] ?></td>
                <td align="center"><?= $campo["estado"] ?></td>
                <td align="center"><?= $campo["ativo"] ?></td>
                <td align="center"><a
                        href="../crud/FormEditarClientes.php?editarid=<?php echo $campo['id_clientes']; ?>">Editar</a></td>
                <td align="center"><a
                        href="../crud/ExcluirClientes.php?p=excluir&clientes=<?php echo $campo['id_clientes']; ?>">Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </table><br>
    <a href="../html/dashboard_adm.php"><input type="button" class="botoes" value="Cancelar" /></a>
</body>

</html>