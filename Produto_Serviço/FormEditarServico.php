<!DOCTYPE html>

<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Editar Serviço</title>
        <link rel="stylesheet" href="../css/prod_serv_php.css"/>
    </head>

    <body>
        <?php
        include("../conectarbd.php");
        $recid = filter_input(INPUT_GET, 'editarid');
        $selecionar = mysqli_query($conn, "SELECT * FROM tb_servicos WHERE id_servicos=$recid");
        $campo = mysqli_fetch_array($selecionar);
        ?>

        <div class="formulario">
            <form method="post" action="EditarServico.php">

                <h1>Alterar Serviço</h1>

                <!--esta linha cria um campo oculto para passar o id_cliente, pois senão ao clicar em Salvar o código não saberá onde salvar.-->
                <input type="hidden" name="id" value="<?= $campo["id_servicos"] ?>"> 

                <label>Nome</label> 
                <input type="text" name="nome" placeholder="Nome" value="<?= $campo["nome"] ?>"> 

                <label>Descrição</label>
                <input type="text" name="descricao" placeholder="Descrição" value="<?= $campo["descricao"] ?>"> 

                <label>Preço</label>
                <input type="number" name="preco" placeholder="Preço" value="<?= $campo["preco"] ?>"> 

                <label>Duração em minutos</label>
                <input type="text" name="duracao_min" placeholder="Duração em minutos" value="<?= $campo["duracao_min"] ?>"> 
                
                <label>ativo</label>
                <input type="text" name="ativo" placeholder="ativo" value="<?= $campo["ativo"] ?>"> 


                <input type="submit" class="botoes" value="Salvar" >
                <a href="FormConsultarServico.php">
                    <input type="button" class="botoes" value="Cancelar"/>
                </a>

            </form>
        </div>
    </body>
</html>
