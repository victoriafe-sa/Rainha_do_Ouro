<?php
session_start();

// Verifica se veio o total e o id do pedido via GET
if (!isset($_GET['pedido_id']) || !isset($_GET['total'])) {
    // Redireciona ou mostra erro se não receber os dados
    header("Location: pedidos.php");
    exit;
}

$pedido_id = (int) $_GET['pedido_id'];
$total = (float) $_GET['total'];

// Aqui você pode, por segurança, validar se o pedido realmente pertence ao usuário logado,
// buscar o pedido no banco e conferir o total, etc.
?>
<?php
include("../conectarbd.php");

$nomeUsuario = "Fazer login"; // fallback

if (isset($_SESSION['id_cliente'])) {
    $id_cliente = $_SESSION['id_cliente'];

    $sqlCliente = "SELECT nome FROM tb_clientes WHERE id_clientes = ?";
    $stmt = $conn->prepare($sqlCliente);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $dadosCliente = $result->fetch_assoc();
        $nomeUsuario = explode(' ', $dadosCliente['nome'])[0]; // pega o primeiro nome
    }
}
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
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pagamento | Rainha do Ouro</title>
    <link rel="stylesheet" href="../css/pagamentos.css" />
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico" />
</head>

<body class="fade-in">
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

    <div class="form-container">
        <div class="payment-container">
            <h1>Formulário de Pagamento</h1>
            <strong><p>Total da compra: R$ <?php echo number_format($total, 2, ',', '.'); ?></p></strong>

            <form class="payment-form" method="POST" action="../crud/pagar_pedido.php">
                <input type="hidden" name="pedido_id" value="<?php echo $pedido_id; ?>">
                <div class="form-group">
                    <label for="nome">Nome completo</label>
                    <input type="text" id="nome" name="nome" placeholder="Ex: João da Silva" required />
                </div>

                <div class="form-group">
                    <label for="numero">Número do cartão</label>
                    <input type="text" id="numero" name="numero" placeholder="1234 5678 9012 3456" pattern="\d{13,19}"
                        title="Digite entre 13 e 19 números" required />
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="codigo">CVV</label>
                        <input type="text" id="codigo" name="codigo" placeholder="Ex: 123" pattern="\d{3,4}"
                            title="Digite 3 ou 4 números" required />
                    </div>

                    <div class="form-group half">
                        <label for="validade">Data de validade</label>
                        <input type="text" id="validade" name="validade" placeholder="MM/AA" required />
                    </div>
                </div>

                <button type="submit" class="btn-pagar">Finalizar Pagamento</button>
            </form>

        </div>
    </div>

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

    <script src="../script/pagamentos.js"></script>
</body>

</html>