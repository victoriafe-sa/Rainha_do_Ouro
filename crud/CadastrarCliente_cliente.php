<?php 
include_once "../conectarbd.php";
        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];
        $data_nascimento = $_POST["data_nascimento"];
        $genero = $_POST["genero"];
        $email = $_POST["email"];
        $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
        
        $conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
        $sql = "INSERT INTO tb_clientes(nome, telefone, data_nascimento, genero, email, senha) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $nome, $telefone, $data_nascimento, $genero, $email, $senha);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Seus dados foram salvos !'); window.location = '../html/pagina_inicial.php';</script>";
        } else {
            echo "Deu erro: " . mysqli_error($conn);
        }
        mysqli_close($conn);
        ?>
