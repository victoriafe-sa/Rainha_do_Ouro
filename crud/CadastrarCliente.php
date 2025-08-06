<?php 
include_once "../conectarbd.php";
        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];
        $cpf = $_POST["cpf"];
        $data_nascimento = $_POST["data_nascimento"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $cep = $_POST["cep"];
        $rua = $_POST["rua"];
        $numero = $_POST["numero"];
        $bairro = $_POST["bairro"];
        $cidade = $_POST["cidade"];
        $estado = $_POST["estado"];
        
        $conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
        mysqli_select_db($conn, 'db_rainhadoouro');
        $sql = "INSERT INTO tb_clientes(nome, telefone,cpf, data_nascimento, email, senha, cep, rua, numero, bairro, cidade, estado) VALUES ('$nome', '$telefone','$cpf', '$data_nascimento', '$email', '$senha', '$cep', '$rua', '$numero', '$bairro', '$cidade', '$estado')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Seus dados foram salvos !'); window.location = '../html/dashboard_adm.php';</script>";
        } else {
            echo "Deu erro: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
        ?>