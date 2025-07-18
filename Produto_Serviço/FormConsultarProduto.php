<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Consultar Produtos</title>
        <link type="text/css" rel="stylesheet" href="../css/consultar.css">
    
    </head>

     <body>
                <h1>Consultar Produtos Cadastrados</h1>
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
                        <td align="center"> <strong>Descrição</strong></td>
                        <td align="center"> <strong>Preço de Venda</strong></td>
                        <td align="center"> <strong>Categoria</strong></td>
                        <td align="center"> <strong>Ativo</strong></td>
                        <td width="10"> <strong>Editar</strong></td>
                        <td width="10"> <strong>Deletar</strong></td>
                    </tr>

                    <?php
                        include("../conectarbd.php");
                        $selecionar= mysqli_query($conn, "SELECT * FROM tb_produtos");
                        while ($campo= mysqli_fetch_array($selecionar)){?>
                            <tr>
                                <td align="center"><?=$campo["id_produtos"]?></td>
                                <td align="center"><?=$campo["nome"]?></td>
                                <td align="center"><?=$campo["descricao"]?></td>
                                <td align="center"><?=$campo["preco_venda"]?></td>
                                <td align="center"><?=$campo["categoria"]?></td>
                                <td align="center"><?=$campo["ativo"]?></td>
                                
                                

                                <td align="center" ><ahref="FormEditarProduto.php?editarid=<?php echo $campo ['id_produtos'];?>">Editar</a></td>
                                <td align="center"><a href="ExcluirProduto.php?p=excluir&produto=<?php echo $campo['id_produtos'];?>">Excluir</a></td>
                            </tr>
                    <?php }?>
                </table><br>
                    <a href="../index.php"><input type="button" class="botoes" value="Cancelar"/></a>
    </body>
</html>
