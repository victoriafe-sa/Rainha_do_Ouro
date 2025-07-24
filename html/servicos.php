<!DOCTYPE html>
<html lang="pt-br">

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
                <li><a href="../html/pagina_inicial.html">Inicio</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="servicos.php">Serviços</a></li>
                <li><a href="../html/agendamentos.html">Agendamento</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="#"><img src="../img/lupa.png" alt="Buscar"></a>
            <a href="../html/carrinho.html"><img src="../img/carrinho.png" alt="Carrinho"></a>
            <a href="../html/perfil_usuario.html"><img src="../img/perfil.png" alt="Perfil"></a>
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
                include ("../conectarbd.php");

                // VERIFICAR ERROS
                if ($conn->connect_error) {
                    die("Erro de conexão: " . $conn->connect_error);
                }

                // CONSULTA OS SERVIÇOS
                $sql = "SELECT nome, descricao, duracao_min FROM tb_servicos";
                $result = $conn->query($sql);

                // EXIBE OS SERVIÇOS
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="serv-card">
                            <img src="../img/trancista.jpeg">
                            <div class="serv-info">
                                <h3>' . htmlspecialchars($row["nome"]) . '</h3>
                                <p>' . htmlspecialchars($row["descricao"]) . '</p>
                                <p>Duração em minutos: ' . htmlspecialchars($row["duracao_min"]) . 'min</p>
                                <a href="../html/agendamentos.html">Agendar</a>
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

    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Rainha do Ouro. Todos os direitos reservados.</p>
            <div class="footer-links">
                <a href="#">Política de Privacidade</a>
                <a href="#">Termos de Uso</a>
                <a href="#">Contato</a>
            </div>
        </div>
    </footer>
</body>

</html>
