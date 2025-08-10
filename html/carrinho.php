<?php
session_start();
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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrinho | Rainha do Ouro</title>
  <link rel="stylesheet" href="../css/carrinho.css">
  <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
</head>

<body>
  <header>
    <div class="logo">
      <img src="../img/logo.png" alt="Rainha do Ouro">
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
  <script>
    const usuarioLogadoId = <?php echo isset($_SESSION['id_cliente']) ? json_encode($_SESSION['id_cliente']) : 'null'; ?>;
  </script>

  <div class="mainSection">
    <div class="productSection">
      <div class="frase-com-coroa">
        <img src="../img/cra.png" alt="Coroa">
        <h2>Carrinho</h2>
        <img src="../img/cra2.png" alt="Coroa">
      </div>
      <main>

        <section class="cartSection">

        </section>

        <section class="price-section">
          <div class="frete-price">
            <h3>Calcular frete</h3>
            <div>
              <input type="text" name="cep" id="cep" placeholder="Digite seu CEP" required>
              <button>Calcular</button>
            </div>

            <a href="https://buscacepinter.correios.com.br/app/endereco/index.php?t#xd_co_f=YzhlNjlhNTItMjgzZi00MjkwLWIyNTEtYmVmNDNhNDBkNTM0~"
              target="_blank">Não sei meu CEP</a>
          </div>
          <div class="prices-resumo">
            <h3>Resumo</h3>
            <p>Subtotal</p>
            <p>Frete</p>
            <p>Total</p>
          </div>
          <form>
            <button type="submit">Finalizar Compra</button>
          </form>


          <button type="button"><a href="../html/produtos.php">Continuar Comprando</a></button>
        </section>

      </main>

      <footer class="site-footer">
        <div class="footer-content">

          <!-- Logo alinhada à esquerda -->
          <div class="footer-esquerda">
            <img src="../img/logo.png" alt="Rainha do Ouro" class="logo-footer">
          </div>

          <!-- Texto e ícones centralizados -->
          <div class="info-footer">
            <p>&copy; 2025 Rainha do Ouro. Todos os direitos reservados.</p>

            <div class="footer-links">
              <a href="#">Política de Privacidade</a>
              <a href="#">Termos de Uso</a>
              <a href="#">Contato</a>
            </div>

            <div class="redes-sociais">
              <a href="#"><img src="../img/instagram-icon.png" alt="Instagram"></a>
              <a href="#"><img src="../img/facebook-icon.png" alt="Facebook"></a>
              <a href="#"><img src="../img/x-icon.png" alt="X"></a>
            </div>
          </div>

        </div>
      </footer>

      <script src="../script/carrinho.js"></script>
</body>

</html>