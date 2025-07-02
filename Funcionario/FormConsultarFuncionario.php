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
                        <td align="center"> <strong>Tipo</strong></td>
                        <td align="center"> <strong>Valor de compra</strong></td>
                        <td align="center"> <strong>Valor de vendas</strong></td>
                        <td align="center"> <strong>Descrição</strong></td>
                        <td width="10"> <strong>Editar</strong></td>
                        <td width="10"> <strong>Deletar</strong></td>
                    </tr>

                    <?php
                        include("../conectarbd.php");
                        $selecionar= mysqli_query($conn, "SELECT * FROM tb_funcionarios");
                        while ($campo= mysqli_fetch_array($selecionar)){?>
                            <tr>
                                <td align="center"><?=$campo["id_produtos"]?></td>
                                <td align="center"><?=$campo["nome"]?></td>
                                <td align="center"><?=$campo["tipo"]?></td>
                                <td align="center"><?=$campo["valor_compra"]?></td>
                                <td align="center"><?=$campo["valor_venda"]?></td>
                                <td align="center"><?=$campo["descricao"]?></td>
                                <td align="center"><a href="FormEditarFuncionario.php?editarid=<?php echo $campo ['id_funcionarios'];?>">Editar</a></td>
                                <td align="center"><i><a href="ExcluirFuncionario.php?p=excluir&funcionario=<?php echo $campo['id_funcionarios'];?>">Excluir</i></a></td>
                            </tr>
                    <?php }?>
                </table><br>
                    <a href="../index.php"><input type="button" class="botoes" value="Cancelar"/></a>
    </body>
</html>
