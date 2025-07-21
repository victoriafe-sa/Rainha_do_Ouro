<?php
require 'conexao.php';

$stmt = $pdo->query("SELECT * FROM imagens");

echo "<h1>Imagens Salvas</h1>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<h3>{$row['nome']}</h3>";
    $imgData = base64_encode($row['imagem']);
    echo '<img src="data:image/jpeg;base64,' . $imgData . '" width="200" style="margin-bottom:20px;"><br>';
}
echo "<br><a href='index.html'>Voltar</a>";
?>
