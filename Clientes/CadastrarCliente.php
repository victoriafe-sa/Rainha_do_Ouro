<?php include_once "../conectarbd.php"; ?>
<html>
    <body>
        <?php
        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];
        $data_nascimento = $_POST["data_nascimento"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $cep = $_POST["cep"];
        $rua = $_POST["rua"];
        $numero = $_POST["numero"];
        $bairro = $_POST["bairro"];
        $cidade = $_POST["cidade"];
        $estado = $_POST["estado"];
        $data_cadastro = $_POST["data_cadastro"];
        $ativo = $_POST["ativo"];
        $conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
        mysqli_select_db($conn, 'db_rainhadoouro');
        $sql = "INSERT INTO tb_clientes(nome, telefone, data_nascimento, email, senha, cep, rua, numero, bairro, cidade, estado, data_cadastro, ativo) VALUES ('$nome', '$telefone', '$data_nascimento', '$email', '$senha', '$cep', '$rua', '$numero', '$bairro', '$cidade', '$estado', '$data_cadastro', '$ativo')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Seus dados foram salvos !'); window.location = '../index.php';</script>";
        } else {
            echo "Deu erro: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
        ?>
    </body>
</html>

/