<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Consultar Serviços</title>
    <link type="text/css" rel="stylesheet" href="../css/consultar.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
</head>

<body>
    <h1>Serviços Cadastrados</h1>
    <form method="GET" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo isset($_GET['nome']) ? $_GET['nome'] : ''; ?>">

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
            <td align="center"> <strong>Preço</strong></td>
            <td align="center"> <strong>Duração (em min)</strong></td>
            <td align="center"> <strong>Ativo</strong></td>
            <td width="10"> <strong>Editar</strong></td>
            <td width="10"> <strong>Deletar</strong></td>
        </tr>

        <?php
        include("../conectarbd.php");
        //$selecionar = mysqli_query($conn, "SELECT * FROM tb_servicos");
        
        $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
        $ativo = isset($_GET['ativo']) ? $_GET['ativo'] : '';

        $sql = "SELECT * FROM tb_servicos WHERE 1=1";

        if (!empty($nome)) {
            $sql .= " AND nome LIKE '%" . mysqli_real_escape_string($conn, $nome) . "%'";
        }
        if ($ativo !== '') {
            $sql .= " AND ativo = '" . mysqli_real_escape_string($conn, $ativo) . "'";
        }

        $selecionar = mysqli_query($conn, $sql);

        while ($campo = mysqli_fetch_array($selecionar)) { ?>
            <tr>
                <td align="center"><?= $campo["id_servicos"] ?></td>
                <td align="center"><?= $campo["nome"] ?></td>
                <td align="center"><?= $campo["descricao"] ?></td>
                <td align="center"><?= $campo["preco"] ?></td>
                <td align="center"><?= $campo["duracao_min"] ?></td>
                <td align="center"><?= $campo["ativo"] ?></td>



                <td align="center"><a
                        href="../crud/FormEditarServico.php?editarid=<?php echo $campo['id_servicos']; ?>">Editar</a></td>
                <td align="center"><a
                        href="../crud/ExcluirServico.php?p=excluir&servico=<?php echo $campo['id_servicos']; ?>">Excluir</a>
                </td>
            </tr>
        <?php } ?>
    </table><br>
    <a href="../html/dashboard_adm.php"><input type="button" class="botoes" value="Cancelar" /></a>
</body>

</html>