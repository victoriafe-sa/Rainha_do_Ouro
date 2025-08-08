<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Consultar Produtos</title>
    <link type="text/css" rel="stylesheet" href="../css/consultar.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
</head>

<body>
    <h1>Produtos Cadastrados</h1>

    <form method="GET" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo isset($_GET['nome']) ? $_GET['nome'] : ''; ?>">

        <label for="categoria">Categoria:</label>
        <input type="text" name="categoria" id="categoria"
            value="<?php echo isset($_GET['categoria']) ? $_GET['categoria'] : ''; ?>">

        <label for="ativo">Ativo:</label>
        <select name="ativo" id="ativo">
            <option value="">Todos</option>
            <option value="1" <?php if (isset($_GET['ativo']) && $_GET['ativo'] === "1")
                echo 'selected'; ?>>Sim</option>
            <option value="0" <?php if (isset($_GET['ativo']) && $_GET['ativo'] === "0")
                echo 'selected'; ?>>Não</option>
        </select>

        <input type="submit" value="Pesquisar" class="botoes">
    </form>
    <br>


    <table width="100%" border="1" bordercolor="black" cellspacing="2" cellpadding="5">
        <tr>
            <td align="center"> <strong>ID</strong></td>
            <td align="center"> <strong>Nome</strong></td>
            <td align="center"> <strong>Descrição</strong></td>
            <td align="center"> <strong>Preço de Venda</strong></td>
            <td align="center"> <strong>Categoria</strong></td>
            <td align="center"> <strong>Estoque</strong></td>
            <td align="center"> <strong>Ativo</strong></td>
            <td width="10"> <strong>Editar</strong></td>
            <td width="10"> <strong>Deletar</strong></td>
        </tr>

        <?php
        include("../conectarbd.php");
        //$selecionar= mysqli_query($conn, "SELECT * FROM tb_produtos");
        
        $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
        $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
        $ativo = isset($_GET['ativo']) ? $_GET['ativo'] : '';

        $sql = "SELECT * FROM tb_produtos WHERE 1=1";

        if (!empty($nome)) {
            $sql .= " AND nome LIKE '%" . mysqli_real_escape_string($conn, $nome) . "%'";
        }
        if (!empty($categoria)) {
            $sql .= " AND categoria LIKE '%" . mysqli_real_escape_string($conn, $categoria) . "%'";
        }
        if ($ativo !== '') {
            $sql .= " AND ativo = '" . mysqli_real_escape_string($conn, $ativo) . "'";
        }

        $selecionar = mysqli_query($conn, $sql);


        while ($campo = mysqli_fetch_array($selecionar)) { ?>
            <tr>
                <td align="center"><?= $campo["id_produtos"] ?></td>
                <td align="center"><?= $campo["nome"] ?></td>
                <td align="center"><?= $campo["descricao"] ?></td>
                <td align="center"><?= $campo["preco_venda"] ?></td>
                <td align="center"><?= $campo["categoria"] ?></td>
                <td align="center"><?= $campo["quantidade_estoque"] ?></td>
                <td align="center"><?= $campo["ativo"] ?></td>

                <td align="center"><a
                        href="../crud/FormEditarProduto.php?editarid=<?php echo $campo['id_produtos']; ?>">Editar</a></td>
                <td align="center"><a
                        href="../crud/ExcluirProduto.php?p=excluir&produto=<?php echo $campo['id_produtos']; ?>">Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </table><br>
    <a href="../html/dashboard_adm.php"><input type="button" class="botoes" value="Cancelar" /></a>
</body>

</html>