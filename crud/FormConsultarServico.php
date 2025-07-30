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
                        <td align="center"> <strong>Preço</strong></td>
                        <td align="center"> <strong>Duração (em min)</strong></td>
                        <td align="center"> <strong>Ativo</strong></td>
                        <td width="10"> <strong>Editar</strong></td>
                        <td width="10"> <strong>Deletar</strong></td>
                    </tr>

                    <?php
                        include("../conectarbd.php");
                        $selecionar= mysqli_query($conn, "SELECT * FROM tb_servicos");
                        while ($campo= mysqli_fetch_array($selecionar)){?>
                            <tr>
                                <td align="center"><?=$campo["id_servicos"]?></td>
                                <td align="center"><?=$campo["nome"]?></td>
                                <td align="center"><?=$campo["descricao"]?></td>
                                <td align="center"><?=$campo["preco"]?></td>
                                <td align="center"><?=$campo["duracao_min"]?></td>
                                <td align="center"><?=$campo["ativo"]?></td>
                                
                                

                                <td align="center"><a href="FormEditarServico.php?editarid=<?php echo $campo ['id_servicos'];?>">Editar</a></td>
                                <td align="center"><a href="ExcluirServico.php?p=excluir&servico=<?php echo $campo['id_servicos'];?>">Excluir</a></td>
                            </tr>
                    <?php }?>
                </table><br>
                    <a href="../html/dashboard.php"><input type="button" class="botoes" value="Cancelar"/></a>
    </body>
</html>
