<?php include_once "../conectarbd.php"; ?>
<html>
    <body>
        <?php
        $nome_completo = $_POST["nome_completo"];
        $data_nascimento = $_POST["data_nascimento"];
        $cpf = $_POST["cpf"];
        $rg = $_POST["rg"];
        $sexo = $_POST["sexo"];
        $estado_civil = $_POST["estado_civil"];
        $telefone = $_POST["telefone"];
        $email = $_POST["email"];
        $cep = $_POST["cep"];
        $rua = $_POST["rua"];
        $numero = $_POST["numero"];
        $bairro = $_POST["bairro"];
        $cidade = $_POST["cidade"];
        $estado = $_POST["estado"];
        $cargo = $_POST["cargo"];
        $horario_trabalho = $_POST["horario_trabalho"];
        $salario = $_POST["salario"];
        $tipo_contrato = $_POST["tipo_contrato"];
        $carteira_trabalho = $_POST["carteira_trabalho"];
        $pis = $_POST["pis"];
        $observacoes = $_POST["observacoes"];
       
        $conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);
        mysqli_select_db($conn, 'db_rainhadoouro');
        $sql = "INSERT INTO tb_funcionarios(nome_completo,data_nascimento,cpf,rg,sexo,estado_civil,telefone,email,cep,rua,numero,bairro,cidade,estado,cargo,horario_trabalho,salario,tipo_contrato,carteira_trabalho,pis,observacoes) VALUES ('$nome_completo','$data_nascimento', '$cpf', '$rg', '$sexo', '$estado_civil','$telefone','$email','$cep','$rua','$numero','$bairro','$cidade','$estado','$cargo','$horario_trabalho','$salario','$tipo_contrato','$carteira_trabalho','$pis','$observacoes')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Seus dados foram salvos !'); window.location = '../index.php';</script>";
        } else {
            echo "Deu erro: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
        ?>
    </body>
</html>
