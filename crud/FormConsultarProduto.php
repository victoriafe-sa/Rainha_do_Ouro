<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Consultar Produtos</title>
    <link type="text/css" rel="stylesheet" href="../css/consultar.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
</head>
<style>
    table {
    width: 100%;
    max-width: 1200px;
    /* aumenta a largura máxima da tabela */
    margin: 0 auto;
    /* centraliza horizontalmente */
    background-color: #f7d794;
    /* opcional, para visual */
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table th,
table td {
    padding: 15px 20px;
    /* aumenta o padding interno das células */
    border: 1px solid #c0a060;
    text-align: center;
    vertical-align: middle;
}

/* Colunas "Editar" e "Excluir" com largura fixa */
table td:nth-last-child(2),
table td:nth-last-child(1),
table th:nth-last-child(2),
table th:nth-last-child(1) {
    width: 80px;
    max-width: 80px;
}

/* Coluna ID */
table td:nth-child(1),
table th:nth-child(1) {
    width: 60px;
}

/* Coluna Preço */
table td:nth-child(4),
table th:nth-child(4) {
    width: 900px;
}

/* Coluna Nome (2ª coluna) */
table td:nth-child(3),
table th:nth-child(3) {
    max-width: 250px;      /* largura máxima */
    white-space: normal;   /* permite quebra de linha */
    word-wrap: break-word; /* força quebra de palavras grandes */
    overflow-wrap: break-word;
}
</style>

<body>
    <h1>Produtos Cadastrados</h1>

    <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?php echo isset($_GET['nome']) ? $_GET['nome'] : ''; ?>">
        </div>

        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" id="categoria" value="<?php echo isset($_GET['categoria']) ? $_GET['categoria'] : ''; ?>">
        </div>

        <div class="form-group">
            <label for="ativo">Ativo:</label>
            <select name="ativo" id="ativo">
                <option value="">Todos</option>
                <option value="1" <?php if (isset($_GET['ativo']) && $_GET['ativo'] === "1") echo 'selected'; ?>>Sim</option>
                <option value="0" <?php if (isset($_GET['ativo']) && $_GET['ativo'] === "0") echo 'selected'; ?>>Não</option>
            </select>
        </div>

        <input type="submit" value="Pesquisar" class="botoes">
    </form>



    <table width="100%" border="1" bordercolor="black" cellspacing="2" cellpadding="5">
        <tr>
            <td align="center"> <strong>ID</strong></td>
            <td align="center"> <strong>Imagem</strong></td>
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
                <td align="center">
                    <img src="../<?= htmlspecialchars($campo["path"]) ?>" alt="Imagem Serviço" style="width:80px; height:auto; border-radius:4px;">
                </td>
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