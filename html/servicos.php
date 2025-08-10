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
<html lang="pt-br">
<!--conectar pagina com as imagens, verificar o imagem upload-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços | Rainha do Ouro</title>
    <link rel="stylesheet" href="../css/servicos.css">
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

    <main>
        <section class="anuncio_mpR">
            <video autoplay loop muted poster="../img/01.mp4">
                <source src="../img/01.mp4" type="video/mp4">
                Seu navegador não suporta o elemento de vídeo.
            </video>
        </section>

        <section class="servContent">
            <div class="servicos">
                <?php
                // CONEXÃO COM O BANCO
                include("../conectarbd.php");

                // VERIFICAR ERROS
                if ($conn->connect_error) {
                    die("Erro de conexão: " . $conn->connect_error);
                }

                // CONSULTA OS SERVIÇOS, incluindo o campo da imagem
                $sql = "SELECT nome, descricao, duracao_min, path FROM tb_servicos";
                $result = $conn->query($sql);

                // EXIBE OS SERVIÇOS
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imgPath = (!empty($row["path"]) && file_exists($row["path"])) ? $row["path"] : "../img/default.jpg";

                        echo '
        <div class="serv-card">
            <img src="' . htmlspecialchars($imgPath) . '" alt="Imagem do Serviço">
            <div class="serv-info">
                <h3>' . htmlspecialchars($row["nome"]) . '</h3>
                <p>' . htmlspecialchars($row["descricao"]) . '</p>
                <p>Duração em minutos: ' . htmlspecialchars($row["duracao_min"]) . 'min</p>
                <a href="../html/agendamentos.php">Agendar</a>
            </div>
        </div>';
                    }
                } else {
                    echo "<p>Nenhum serviço cadastrado ainda.</p>";
                }

                $conn->close();
                ?>

            </div>
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
</body>

</html>