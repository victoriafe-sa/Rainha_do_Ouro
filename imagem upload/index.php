<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Upload de Imagem</title>
</head>
<body>
    <h1>Upload de Imagem</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="nome" placeholder="Nome da imagem" required><br><br>
        <input type="file" name="imagem" accept="image/*" required><br><br>
        <button type="submit">Enviar</button>
    </form>
    <br>
    <a href="exibir.php">Ver imagens salvas</a>
</body>
</html>
