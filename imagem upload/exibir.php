<?php
require '../conectarbd.php';

$sql = "SELECT * FROM tb_imagens";
$result = mysqli_query($conn, $sql);

echo "<h1>Imagens Salvas</h1>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<h3>" . htmlspecialchars($row['nome']) . "</h3>";
    $imgData = base64_encode($row['imagem']);
    echo '<img src="data:image/jpeg;base64,' . $imgData . '" width="200" style="margin-bottom:20px;"><br>';
}

echo "<br><a href='index.php'>Voltar</a>";
?>
