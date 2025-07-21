<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Consultar Funcioonario:</title>
        <link type="text/css" rel="stylesheet" href="estilo.css">
    
    </head>

     <body>
                <h1>Consultar Funcionarios Cadastrados:</h1>
                <table
                   width="100%"
                   border="1" 
                   bordercolor="black"
                   cellspacing="2" 	
                   cellpadding="5"
                   >
                    <tr>
                    <td align="center"> <strong>ID</strong></td>	
                    <td align="center"> <strong>Nome</strong></td>	
                    <td align="center"> <strong>Data de Nascimento</strong></td>	
                    <td align="center"> <strong>CPF</strong></td>	
                    <td align="center"> <strong>RG</strong></td>	
                    <td align="center"> <strong>Telefone</strong></td>	
                    <td align="center"> <strong>E-mail</strong></td>	
                    <td align="center"> <strong>Bairro</strong></td>	
                    <td align="center"> <strong>Cidade</strong></td>	
                    <td align="center"> <strong>Estado</strong></td>	
                    <td align="center"> <strong>Cargo</strong></td>	
                    <td align="center"> <strong>Data de admissão</strong></td>	
                    <td align="center"> <strong>Horário de trabalho</strong></td>	
                    <td align="center"> <strong>Salário</strong></td>	
                    <td align="center"> <strong>Tipo de contrato</strong></td>	
                    <td align="center"> <strong>Status</strong></td>	
                    <td align="center"> <strong>Observações</strong></td>
                        <td width="10"> <strong>Editar</strong></td>
                        <td width="10"> <strong>Deletar</strong></td>
                    </tr>

                    <?php
                        include("../conectarbd.php");
                        $selecionar= mysqli_query($conn, "SELECT * FROM tb_funcionarios");
                        while ($campo= mysqli_fetch_array($selecionar)){?>
                            <tr>
                            <td align="center"><?=$campo["id_funcionarios"]?></td>
                            <td align="center"><?=$campo["nome_completo"]?></td>
                            <td align="center"><?=$campo["data_nascimento"]?></td>
                            <td align="center"><?=$campo["cpf"]?></td>
                            <td align="center"><?=$campo["rg"]?></td>
                            <td align="center"><?=$campo["telefone"]?></td>
                            <td align="center"><?=$campo["email"]?></td>
                            <td align="center"><?=$campo["bairro"]?></td>
                            <td align="center"><?=$campo["cidade"]?></td>
                            <td align="center"><?=$campo["estado"]?></td>
                            <td align="center"><?=$campo["cargo"]?></td>
                            <td align="center"><?=$campo["data_admissao"]?></td>
                            <td align="center"><?=$campo["horario_trabalho"]?></td>
                            <td align="center"><?=$campo["salario"]?></td>
                            <td align="center"><?=$campo["tipo_contrato"]?></td>
                            <td align="center"><?=$campo["status"]?></td>
                            <td align="center"><?=$campo["observacoes"]?></td>
                                <td align="center"><a href="FormEditarFuncionario.php?editarid=<?php echo $campo ['id_funcionarios'];?>">Editar</a></td>
                                <td align="center"><i><a href="ExcluirFuncionario.php?p=excluir&funcionario=<?php echo $campo['id_funcionarios'];?>">Excluir</i></a></td>
                            </tr>
                    <?php }?>
                </table><br>
                    <a href="../index.php"><input type="button" class="botoes" value="Cancelar"/></a>
    </body>
</html>
