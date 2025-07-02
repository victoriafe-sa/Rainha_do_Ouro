<!DOCTYPE html>

<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Editar Advogado</title>
        <link rel="stylesheet" href="../css/prod_serv_php.css"/>
    </head>

    <body>
        <?php
        include("../conectarbd.php");
        $recid = filter_input(INPUT_GET, 'editarid');
        $selecionar = mysqli_query($conn, "SELECT * FROM tb_produtos WHERE id_produtos=$recid");
        $campo = mysqli_fetch_array($selecionar);
        ?>

        <div class="formulario">
            <form method="post" action="EditarProduto.php">

                <h1>Alterar Produto</h1>

                <!--esta linha cria um campo oculto para passar o id_cliente, pois senão ao clicar em Salvar o código não saberá onde salvar.-->
                <input type="hidden" name="id" value="<?= $campo["id_produtos"] ?>"> 

                <label>Nome</label> 
                <input type="text" name="nome" placeholder="Nome" value="<?= $campo["nome"] ?>"> 

                <label>Descrição</label>
                <input type="text" name="descricao" placeholder="Descrição" value="<?= $campo["descricao"] ?>"> 

                <label>Preço de Venda</label>
                <input type="number" name="preco_venda" placeholder="Preço de Venda" value="<?= $campo["preco_venda"] ?>"> 
                
                <label>Categoria</label>
                <input type="text" name="categoria" placeholder="Categoria" value="<?= $campo["categoria"] ?>"> 

                <label>Ativo</label>
                <input type="text" name="ativo" placeholder="Ativo" value="<?= $campo["ativo"] ?>"> 


                <input type="submit" class="botoes" value="Salvar" >
                <a href="FormConsultarProduto.php"><input type="button" class="botoes" value="Cancelar"/></a>

            </form>
        </div>

    </body>
</html>
