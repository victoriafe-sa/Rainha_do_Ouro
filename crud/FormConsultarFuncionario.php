<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Consultar Funcionário</title>
    <link type="text/css" rel="stylesheet" href="../css/consultar.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
</head>

<body>
    <h1>Funcionários Cadastrados</h1>

    <form method="GET" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo isset($_GET['nome']) ? $_GET['nome'] : ''; ?>">

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" value="<?php echo isset($_GET['cpf']) ? $_GET['cpf'] : ''; ?>">

        <label for="cargo">Cargo:</label>
        <input type="text" name="cargo" id="cargo" value="<?php echo isset($_GET['cargo']) ? $_GET['cargo'] : ''; ?>">

        <input type="submit" value="Pesquisar" class="botoes">
    </form>
    <br>


    <table width="100%" border="1" bordercolor="black" cellspacing="2" cellpadding="5">
        <tr>
            <td align="center"> <strong>ID</strong></td>
            <td align="center"> <strong>Nome</strong></td>
            <td align="center"> <strong>Data de Nascimento</strong></td>
            <td align="center"> <strong>CPF</strong></td>
            <td align="center"> <strong>Telefone</strong></td>
            <td align="center"> <strong>E-mail</strong></td>
            <td align="center"> <strong>Bairro</strong></td>
            <td align="center"> <strong>Cidade</strong></td>
            <td align="center"> <strong>Cargo</strong></td>
            <td align="center"> <strong>Data de admissão</strong></td>
            <td align="center"> <strong>Horário de trabalho</strong></td>
            <td align="center"> <strong>Tipo de contrato</strong></td>
            <td align="center"> <strong>Status</strong></td>
            <td width="10"> <strong>Editar</strong></td>
            <td width="10"> <strong>Deletar</strong></td>
        </tr>

        <?php
        include("../conectarbd.php");
        
        //$selecionar = mysqli_query($conn, "SELECT * FROM tb_funcionarios");

        $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
        $cpf = isset($_GET['cpf']) ? $_GET['cpf'] : '';
        $cargo = isset($_GET['cargo']) ? $_GET['cargo'] : '';

        // Consulta com filtros dinâmicos
        $sql = "SELECT * FROM tb_funcionarios WHERE 1=1";

        if (!empty($nome)) {
            $sql .= " AND nome_completo LIKE '%" . mysqli_real_escape_string($conn, $nome) . "%'";
        }
        if (!empty($cpf)) {
            $sql .= " AND cpf LIKE '%" . mysqli_real_escape_string($conn, $cpf) . "%'";
        }
        if (!empty($cargo)) {
            $sql .= " AND cargo LIKE '%" . mysqli_real_escape_string($conn, $cargo) . "%'";
        }

        $selecionar = mysqli_query($conn, $sql);


        while ($campo = mysqli_fetch_array($selecionar)) { ?>
            <tr>
                <td align="center"><?= $campo["id_funcionarios"] ?></td>
                <td align="center"><?= $campo["nome_completo"] ?></td>
                <td align="center"><?= $campo["data_nascimento"] ?></td>
                <td align="center"><?= $campo["cpf"] ?></td>
                <td align="center"><?= $campo["telefone"] ?></td>
                <td align="center"><?= $campo["email"] ?></td>
                <td align="center"><?= $campo["bairro"] ?></td>
                <td align="center"><?= $campo["cidade"] ?></td>
                <td align="center"><?= $campo["cargo"] ?></td>
                <td align="center"><?= $campo["data_cadastro"] ?></td>
                <td align="center"><?= $campo["horario_trabalho"] ?></td>
                <td align="center"><?= $campo["tipo_contrato"] ?></td>
                <td align="center"><?= $campo["status"] ?></td>
                <td align="center"><a
                        href="../crud/FormEditarFuncionario.php?editarid=<?php echo $campo['id_funcionarios']; ?>">Editar</a>
                </td>
                <td align="center"><i><a
                            href="../crud/ExcluirFuncionario.php?p=excluir&funcionario=<?php echo $campo['id_funcionarios']; ?>">Excluir</i></a>
                </td>
            </tr>
        <?php } ?>
    </table><br>
    <a href="../html/dashboard_adm.php"><input type="button" class="botoes" value="Cancelar" /></a>
</body>

</html>