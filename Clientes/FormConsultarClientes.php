<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Consultar Clientes</title>
        <link type="text/css" rel="stylesheet" href="estilo.css">
    
    </head>

     <body>
                <h1>Consultar Clientes Cadastrados</h1>
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
                        <td align="center"> <strong>Telefone</strong></td>
                        <td align="center"> <strong>Data de Nascimento</strong></td>
                        <td align="center"> <strong>Email</strong></td>
                        <td align="center"> <strong>Senha</strong></td>
                        <td align="center"> <strong>CEP</strong></td>
                        <td align="center"> <strong>Rua</strong></td>
                        <td align="center"> <strong>Numero</strong></td>
                        <td align="center"> <strong>Bairro</strong></td>
                        <td align="center"> <strong>Cidade</strong></td>
                        <td align="center"> <strong>Estado</strong></td>
                        <td align="center"> <strong>Data de Cadastro</strong></td>
                        <td align="center"> <strong>Ativo</strong></td>

                    </tr>

                    <?php
                        include("../conectarbd.php");
                        $selecionar= mysqli_query($conn, "SELECT * FROM tb_clientes");
                        while ($campo= mysqli_fetch_array($selecionar)){?>
                            <tr>
                                <td align="center"><?=$campo["id_clientes"]?></td>
                                <td align="center"><?=$campo["nome"]?></td>
                                <td align="center"><?=$campo["telefone"]?></td>
                                <td align="center"><?=$campo["data_nascimento"]?></td>
                                <td align="center"><?=$campo["email"]?></td>
                                <td align="center"><?=$campo["senha"]?></td>
                                <td align="center"><?=$campo["cep"]?></td>
                                <td align="center"><?=$campo["rua"]?></td>
                                <td align="center"><?=$campo["numero"]?></td>
                                <td align="center"><?=$campo["bairro"]?></td>
                                <td align="center"><?=$campo["cidade"]?></td>
                                <td align="center"><?=$campo["estado"]?></td>
                                <td align="center"><?=$campo["data_cadastro"]?></td>
                                <td align="center"><?=$campo["ativo"]?></td>
                                <td align="center"><a href="FormEditarClientes.php?editarid=<?php echo $campo ['id_clientes'];?>">Editar</a></td>
                                <td align="center"><i><a href="ExcluirClientes.php?p=excluir&clientes=<?php echo $campo['id_clientes'];?>">Excluir</i></a></td>
                            </tr>
                    <?php }?>
                </table><br>
                    <a href="../index.php"><input type="button" class="botoes" value="Cancelar"/></a>
    </body>
</html>
