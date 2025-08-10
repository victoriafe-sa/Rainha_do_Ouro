<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
    header("Location: user_login.php");
    exit;
}

include("../conectarbd.php");

$imagemPerfil = "../img/03.png";

if (isset($_SESSION['id_cliente'])) {
    $id_cliente = $_SESSION['id_cliente'];

    $sqlCliente = "SELECT nome, genero FROM tb_clientes WHERE id_clientes = ?";
    $stmt = $conn->prepare($sqlCliente);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $dadosCliente = $result->fetch_assoc();
        $nomeUsuario = explode(' ', $dadosCliente['nome'])[0]; // pega o primeiro nome

        // Define imagem pelo gênero
        if ($dadosCliente['genero'] === 'Feminino') {
            $imagemPerfil = "../img/01.png";
        } elseif ($dadosCliente['genero'] === 'Masculino') {
            $imagemPerfil = "../img/02.png";
        } else {
            $imagemPerfil = "../img/03.png";
        }
    }
}
$id_cliente = $_SESSION['id_cliente'];

// Buscar dados completos do cliente (uma consulta só)
$sqlCliente = "SELECT * FROM tb_clientes WHERE id_clientes = ?";
$stmt = $conn->prepare($sqlCliente);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$dadosCliente = $stmt->get_result()->fetch_assoc();

// Preparar o nome curto para exibir no cabeçalho
$nomeUsuario = "Fazer login";
if ($dadosCliente && isset($dadosCliente['nome'])) {
    $nomeUsuario = explode(' ', $dadosCliente['nome'])[0]; // primeiro nome
}

// Buscar pedidos do cliente
$sqlPedidos = "SELECT * FROM tb_pedidos WHERE id_cliente = ? ORDER BY data_pedido DESC";
$stmt = $conn->prepare($sqlPedidos);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$pedidos = $stmt->get_result();

// Buscar agendamentos
$sqlAgendamentos = "SELECT * FROM tb_agendamentos WHERE tb_clientes_id_clientes = ? ORDER BY data DESC, horario DESC";
$stmt = $conn->prepare($sqlAgendamentos);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$agendamentos = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Perfil de Usuário | Rainha do Ouro</title>
    <link rel="stylesheet" href="../css/perfil_usuario.css" />
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico" />
</head>

<body>
    <header>
        <div class="logo">
            <img src="../img/logo.png" alt="Rainha do Ouro" />
        </div>
        <nav>
            <ul>
                <li><a href="../html/pagina_inicial.php">Inicio</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="servicos.php">Serviços</a></li>
                <li><a href="../html/agendamentos.php">Agendar</a></li>
            </ul>
        </nav>
        <div class="icons" style="display:flex; align-items:center; gap:8px;">
            <a href="../html/carrinho.php"><img src="../img/carrinho.png" alt="Carrinho" /></a>
            <?php
    $perfilUrl = isset($_SESSION['id_cliente']) ? '../html/perfil_usuario.php' : '../html/user_login.php';
    ?>
            <a href="<?php echo isset($_SESSION['id_cliente']) ? '../html/perfil_usuario.php' : '../html/user_login.php'; ?>"
                style="display:flex; align-items:center; gap:6px; text-decoration:none; color:#F7E1A0; font-weight:700;">
                <img src="<?php echo $imagemPerfil; ?>" alt="Foto do Perfil" />
                <span><?php echo htmlspecialchars($nomeUsuario); ?></span>
            </a>
        </div>

    </header>

    <main class="profile-container">
        <h1>Meu Perfil</h1>

        <section class="profile-section">
            <h2>Meus Dados</h2>
            <form class="profile-form" method="post" action="../crud/EditarCliente_cliente.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($dadosCliente['id_clientes']); ?>" />

                <label>Nome Completo:</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($dadosCliente['nome']); ?>" />

                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($dadosCliente['email']); ?>" />

                <label>Telefone:</label>
                <input type="text" name="telefone" value="<?php echo htmlspecialchars($dadosCliente['telefone']); ?>" />

                <label>CPF:</label>
                <input type="text" name="cpf" value="<?php echo htmlspecialchars($dadosCliente['cpf']); ?>" />

                <label>Senha:</label>
                <input type="text" name="senha" value="<?php echo htmlspecialchars($dadosCliente['senha']); ?>" />

                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" onblur="pesquisacep(this.value)"
                    value="<?php echo htmlspecialchars($dadosCliente['cep']); ?>" />

                <label for="rua">Endereço</label>
                <input type="text" id="logradouro" name="rua"
                    value="<?php echo htmlspecialchars($dadosCliente['rua']); ?>" />

                <label for="numero">Número</label>
                <input type="text" id="numero" name="numero"
                    value="<?php echo htmlspecialchars($dadosCliente['numero']); ?>" />

                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" name="bairro"
                    value="<?php echo htmlspecialchars($dadosCliente['bairro']); ?>" />

                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade"
                    value="<?php echo htmlspecialchars($dadosCliente['cidade']); ?>" />

                <label for="estado">Estado</label>
                <input type="text" id="estado" name="estado"
                    value="<?php echo htmlspecialchars($dadosCliente['estado']); ?>" />

                <button type="submit">Salvar Alterações</button>
            </form>
        </section>

        <section class="profile-section" id="pedidos">
            <h2>Meus Pedidos</h2>
            <ul class="orders-list">
                <?php while ($pedido = $pedidos->fetch_assoc()): ?>
                <li>
                    Pedido #<?php echo htmlspecialchars($pedido['id_pedidos']); ?> -
                    Total: R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?> -
                    Status: <?php echo htmlspecialchars($pedido['status']); ?>
                    <div class="actions">
                        <form method="GET" action="pagamentos.php" style="display:inline;">
                            <input type="hidden" name="pedido_id"
                                value="<?php echo htmlspecialchars($pedido['id_pedidos']); ?>">
                            <input type="hidden" name="total" value="<?php echo htmlspecialchars($pedido['total']); ?>">
                            <button type="submit" class="pay-btn">Pagar</button>
                        </form>
                        <form method="POST" action="../crud/cancelar_pedido.php"
                            onsubmit="return confirm('Cancelar este pedido?');">
                            <input type="hidden" name="id_pedido"
                                value="<?php echo htmlspecialchars($pedido['id_pedidos']); ?>">
                            <button type="submit" class="cancel-btn">Cancelar</button>
                        </form>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
        </section>


        <section class="profile-section" id="agendamentos">
            <h2>Meus Agendamentos</h2>
            <ul class="appointments-list">
                <?php while ($agendamento = $agendamentos->fetch_assoc()): ?>
                <li>
                    <?php echo date("d/m/Y", strtotime($agendamento['data'])); ?> -
                    <?php echo substr($agendamento['horario'], 0, 5); ?> -
                    <?php echo htmlspecialchars($agendamento['servico']); ?> -
                    <?php echo htmlspecialchars($agendamento['status']); ?>
                    <div class="actions">
                        <form method="POST" action="../crud/cancelar_agendamento.php"
                            onsubmit="return confirm('Cancelar este agendamento?');">
                            <input type="hidden" name="id_agendamento"
                                value="<?php echo htmlspecialchars($agendamento['id_agendamentos']); ?>">
                            <button type="submit" class="cancel-btn">Cancelar</button>
                        </form>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
        </section>


        <div>
            <a href="../crud/logout.php" class="logout-btn">Sair</a>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-esquerda">
                <img src="../img/logo.png" alt="Rainha do Ouro" class="logo-footer" />
            </div>
            <div class="info-footer">
                <p>&copy; 2025 Rainha do Ouro. Todos os direitos reservados.</p>
                <div class="footer-links">
                    <a href="#">Política de Privacidade</a>
                    <a href="#">Termos de Uso</a>
                    <a href="#">Contato</a>
                </div>
                <div class="redes-sociais">
                    <a href="#"><img src="../img/instagram-icon.png" alt="Instagram" /></a>
                    <a href="#"><img src="../img/facebook-icon.png" alt="Facebook" /></a>
                    <a href="#"><img src="../img/x-icon.png" alt="X" /></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="../script/perfil_usuario.js"></script>
</body>

</html>