<!DOCTYPE html>
<html lang="pt-br">
<!--Fazer os filtros e conectar as imagens-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos | Rainha do Ouro</title>
    <link rel="stylesheet" href="../css/produtos_php.css">
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
                <li><a href="../html/produtos.php">Produtos</a></li>
                <li><a href="../html/servicos.php">Serviços</a></li>
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
        <!--Seção da barra de pesquisa-->
        <div class="searchSection">
            <form method="GET" class="searchBar">
                <input type="text" name="busca" class="bar" placeholder="Buscar produto"
                    value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">

            </form>

        </div>
        <div class="mainSection">
            <div class="productSection">
                <h2>Nossos Produtos</h2>
                <div class="products">

                    <?php
                    include("../conectarbd.php");

                    $busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

                    if ($busca !== '') {
                        $sql = "SELECT * FROM tb_produtos WHERE ativo = 1 AND nome LIKE ?";
                        $stmt = $conn->prepare($sql);
                        $busca_param = "%$busca%";
                        $stmt->bind_param("s", $busca_param);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    } else {
                        $sql = "SELECT * FROM tb_produtos WHERE ativo = 1";
                        $result = $conn->query($sql);
                    }

                    if ($result->num_rows > 0) {
                        while ($produto = $result->fetch_assoc()) {
                            // Define caminho da imagem com fallback
                            $imgPath = (!empty($produto["path"]) && file_exists($produto["path"])) ? $produto["path"] : "../img/default.jpg";

                            echo '
                            <div class="product-card">
                                <img src="' . htmlspecialchars($imgPath) . '" alt="Imagem do produto">
                                <p id="product-name">' . htmlspecialchars($produto["nome"]) . '</p>
                                <p id="product-brand">' . htmlspecialchars($produto["categoria"]) . '</p>
                                <span>R$ ' . number_format($produto["preco_venda"] + 10, 2, ',', '.') . '</span>
                                <p id="product-price">R$ ' . number_format($produto["preco_venda"], 2, ',', '.') . '</p>
                                <button onclick="addToCart(this)">comprar</button>
                            </div>';
                        }
                    } else {
                        echo "<p>Nenhum produto encontrado.</p>";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
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

    <script>
    function addToCart(button) {
        const productCard = button.closest('.product-card');

        const name = productCard.querySelector('#product-name')?.textContent || 'Produto';
        const brand = productCard.querySelector('#product-brand')?.textContent || '';
        const priceText = productCard.querySelector('#product-price')?.textContent.replace('R$', '').replace(',', '.')
            .trim();
        const price = parseFloat(priceText) || 0;
        const imageUrl = productCard.querySelector('img')?.getAttribute('src') || '';

        const product = {
            name: name,
            brand: brand,
            price: price,
            imageUrl: imageUrl,
            quantity: 1
        };

        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Verifica se o produto já está no carrinho
        const existingProduct = cart.find(item => item.name === product.name && item.brand === product.brand);
        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push(product);
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`${product.name} foi adicionado ao carrinho!`);
        // Redirecionar para o carrinho, se quiser:
        // window.location.href = "../html/carrinho.html";
    }
    </script>
</body>

</html>