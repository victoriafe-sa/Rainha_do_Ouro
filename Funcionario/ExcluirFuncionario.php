<?php
include("../conectarbd.php");

$recid = filter_input(INPUT_GET, 'funcionario', FILTER_VALIDATE_INT);

if ($recid === null || $recid === false) {
    echo "<script>alert('ID inválido!'); window.location = 'FormConsultarFuncionario.php';</script>";
    exit;
}

$stmt = mysqli_prepare($conn, "DELETE FROM tb_funcionarios WHERE id_funcionarios = ?");
mysqli_stmt_bind_param($stmt, "i", $recid);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Dados excluídos com sucesso!'); window.location = 'FormConsultarFuncionario.php';</script>";
} else {
    echo "Não foi possível excluir os dados no Banco de Dados: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
