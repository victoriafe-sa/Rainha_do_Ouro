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
                    <td align="center"> <strong>nome_completo</strong></td>	
                    <td align="center"> <strong>data_nascimento</strong></td>	
                    <td align="center"> <strong>cpf</strong></td>	
                    <td align="center"> <strong>rg</strong></td>	
                    <td align="center"> <strong>sexo</strong></td>	
                    <td align="center"> <strong>estado_civil</strong></td>	
                    <td align="center"> <strong>telefone</strong></td>	
                    <td align="center"> <strong>email</strong></td>	
                    <td align="center"> <strong>cep</strong></td>	
                    <td align="center"> <strong>rua</strong></td>	
                    <td align="center"> <strong>numero</strong></td>	
                    <td align="center"> <strong>bairro</strong></td>	
                    <td align="center"> <strong>cidade</strong></td>	
                    <td align="center"> <strong>estado</strong></td>	
                    <td align="center"> <strong>cargo</strong></td>	
                    <td align="center"> <strong>data_admissao</strong></td>	
                    <td align="center"> <strong>horario_trabalho</strong></td>	
                    <td align="center"> <strong>salario</strong></td>	
                    <td align="center"> <strong>tipo_contrato</strong></td>	
                    <td align="center"> <strong>carteira_trabalho</strong></td>	
                    <td align="center"> <strong>pis</strong></td>	
                    <td align="center"> <strong>status</strong></td>	
                    <td align="center"> <strong>observacoes</strong></td>	
                    <td align="center"> <strong>data_cadastro</strong></td>
                        <td width="10"> <strong>Editar</strong></td>
                        <td width="10"> <strong>Deletar</strong></td>
                    </tr>

                    <?php
                        include("../conectarbd.php");
                        $selecionar= mysqli_query($conn, "SELECT * FROM tb_funcionarios");
                        while ($campo= mysqli_fetch_array($selecionar)){?>
                            <tr>
                            <td align="center"><?=$campo["nome_completo"]?></td>
                            <td align="center"><?=$campo["data_nascimento"]?></td>
                            <td align="center"><?=$campo["cpf"]?></td>
                            <td align="center"><?=$campo["rg"]?></td>
                            <td align="center"><?=$campo["sexo"]?></td>
                            <td align="center"><?=$campo["estado_civil"]?></td>
                            <td align="center"><?=$campo["telefone"]?></td>
                            <td align="center"><?=$campo["email"]?></td>
                            <td align="center"><?=$campo["cep"]?></td>
                            <td align="center"><?=$campo["rua"]?></td>
                            <td align="center"><?=$campo["numero"]?></td>
                            <td align="center"><?=$campo["bairro"]?></td>
                            <td align="center"><?=$campo["cidade"]?></td>
                            <td align="center"><?=$campo["estado"]?></td>
                            <td align="center"><?=$campo["cargo"]?></td>
                            <td align="center"><?=$campo["data_admissao"]?></td>
                            <td align="center"><?=$campo["horario_trabalho"]?></td>
                            <td align="center"><?=$campo["salario"]?></td>
                            <td align="center"><?=$campo["tipo_contrato"]?></td>
                            <td align="center"><?=$campo["carteira_trabalho"]?></td>
                            <td align="center"><?=$campo["pis"]?></td>
                            <td align="center"><?=$campo["status"]?></td>
                            <td align="center"><?=$campo["observacoes"]?></td>
                            <td align="center"><?=$campo["data_cadastro"]?></td>
                                <td align="center"><a href="FormEditarFuncionario.php?editarid=<?php echo $campo ['id_funcionarios'];?>">Editar</a></td>
                                <td align="center"><i><a href="ExcluirFuncionario.php?p=excluir&funcionario=<?php echo $campo['id_funcionarios'];?>">Excluir</i></a></td>
                            </tr>
                    <?php }?>
                </table><br>
                    <a href="../index.php"><input type="button" class="botoes" value="Cancelar"/></a>
    </body>
</html>
