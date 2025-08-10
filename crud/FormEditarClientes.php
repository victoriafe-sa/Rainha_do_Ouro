<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Clientes</title>
    <link rel="stylesheet" href="../css/editar.css"/>
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
</head>

<body>
    <?php
        include("../conectarbd.php");
        $recid = filter_input(INPUT_GET, 'editarid', FILTER_VALIDATE_INT);
        $selecionar = mysqli_query($conn, "SELECT * FROM tb_clientes WHERE id_clientes = $recid");
        $campo = mysqli_fetch_array($selecionar);
    ?>

    <div class="formulario">
        <h1>Editar Clientes</h1>
        <form method="post" action="EditarCliente.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($campo["id_clientes"]) ?>">

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Nome" value="<?= htmlspecialchars($campo["nome"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="tel" id="telefone" name="telefone" placeholder="Telefone" value="<?= htmlspecialchars($campo["telefone"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento</label>
                <input type="date" id="data_nascimento" name="data_nascimento" value="<?= htmlspecialchars($campo["data_nascimento"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($campo["email"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Senha" value="<?= htmlspecialchars($campo["senha"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" placeholder="CEP" value="<?= htmlspecialchars($campo["cep"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="rua">Rua</label>
                <input type="text" id="rua" name="rua" placeholder="Rua" value="<?= htmlspecialchars($campo["rua"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="numero">Número</label>
                <input type="number" id="numero" name="numero" placeholder="Número" value="<?= htmlspecialchars($campo["numero"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" name="bairro" placeholder="Bairro" value="<?= htmlspecialchars($campo["bairro"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade" placeholder="Cidade" value="<?= htmlspecialchars($campo["cidade"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <input type="text" id="estado" name="estado" placeholder="Estado" maxlength="2" value="<?= htmlspecialchars($campo["estado"]) ?>" required>
            </div>

            <div class="form-group">
                <label for="ativo">Ativo</label>
                <select id="ativo" name="ativo" required>
                    <option value="1" <?= ($campo["ativo"] == 1) ? 'selected' : '' ?>>Sim</option>
                    <option value="0" <?= ($campo["ativo"] == 0) ? 'selected' : '' ?>>Não</option>
                </select>
            </div>

            <div class="form-buttons">
                <input type="submit" class="botoes" value="Salvar">
                <button type="button" class="botoes" onclick="window.location.href='../crud/FormConsultarClientes.php'">Cancelar</button>
            </div>
        </form>
    </div>
</body>
</html>
