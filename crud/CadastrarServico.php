<?php include_once "../conectarbd.php"; ?>
<html>
    <body>
        <?php
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $preco = $_POST["preco"];
        $duracao_min = $_POST["duracao_min"];
        
      
        $conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
        mysqli_select_db($conn, 'db_rainhadoouro');
        $sql = "INSERT INTO tb_servicos(nome,descricao,preco,duracao_min) VALUES ('$nome', '$descricao', '$preco', '$duracao_min')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Serviço adicionado com sucesso!'); window.location = '../html/dashboard.php';</script>";
        } else {
            echo "Deu erro: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
        ?>
    </body>
</html>

