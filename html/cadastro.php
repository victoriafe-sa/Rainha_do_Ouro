<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h2>Cadastro de Usuário</h2>
    <form action="cadastrar_usuario.php" method="POST">
        <input type="email" name="email" placeholder="Digite seu email" required><br><br>
        <input type="password" name="senha" placeholder="Digite sua senha" required><br><br>
        <input type="submit" value="Cadastrar">
    </form>
    <p>Já tem conta? <a href="login_adm.php">Faça login aqui.</a></p>
</body>
</html>
