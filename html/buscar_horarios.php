<?php
// verificar_horarios.php
$servidor = "localhost";
$dbusuario = "root";
$dbsenha = "";
$dbname = "db_rainhadoouro";

$conn = mysqli_connect($servidor, $dbusuario, $dbsenha, $dbname);

$data = $_GET['data'] ?? '';

if ($data) {
    $sql = "SELECT horario FROM tb_agendamentos WHERE data = '$data'";
    $result = mysqli_query($conn, $sql);

    $horarios = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $horarios[] = $row['horario'];
    }

    echo json_encode($horarios);
} else {
    echo json_encode([]);
}

mysqli_close($conn);
?>