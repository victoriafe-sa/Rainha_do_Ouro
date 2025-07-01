<?php include_once "../conectarbd.php"; ?>
<html>
    <body>
        <?php
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $preco_venda = $_POST["preco_venda"];
        $categoria = $_POST["categoria"];
        $ativo = $_POST["ativo"];
      
        $conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
        mysqli_select_db($conn, 'db_rainhadoouro');
        $sql = "INSERT INTO tb_produtos(nome,descricao,preco_venda,categoria,ativo) VALUES ('$nome', '$descricao', '$preco_venda', '$categoria', '$ativo')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Produto adicionado com sucesso!'); window.location = '../index.php';</script>";
        } else {
            echo "Deu erro: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
        ?>
    </body>
</html>