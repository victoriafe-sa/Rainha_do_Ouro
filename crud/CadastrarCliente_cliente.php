<?php 
include_once "../conectarbd.php";
        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];
        $data_nascimento = $_POST["data_nascimento"];
        $genero = $_POST["genero"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        
        $conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
        mysqli_select_db($conn, 'db_rainhadoouro');
        $sql = "INSERT INTO tb_clientes(nome, telefone, data_nascimento, genero, email, senha) VALUES ('$nome', '$telefone', '$data_nascimento','$genero', '$email', '$senha')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Seus dados foram salvos !'); window.location = '../html/pagina_inicial.php';</script>";
        } else {
            echo "Deu erro: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
        ?>
