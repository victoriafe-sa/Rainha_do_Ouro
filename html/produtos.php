<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos | Rainha do Ouro</title>
    <link rel="stylesheet" href="../css/produtos.css">
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
                <li><a href="../html/produtos.html">Produtos</a></li>
                <li><a href="../html/servicos.html">Serviços</a></li>
                <li><a href="../html/agendamentos.html">Agendamento</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="#"><img src="../img/lupa.png" alt="Buscar"></a>
            <a href="../html/carrinho.html"><img src="../img/carrinho.png " alt="Carrinho"></a>
            <a href=""><img src="../img/perfil.png" alt="Perfil"></a>
        </div>
    </header>

    <main>
        <!--Seção da barra de pesquisa-->
        <div class="searchSection">
            <div class="searchBar">
                <input type="text" class="bar" placeholder="Buscar produto">
                <img src="../img/lupa_pd.png" alt="lupa">
            </div>
        </div>
        <div class="mainSection">
            <!--Seção dos filtros-->
            <div class="filterSection">
                <div class="filterTitle">
                    <h2>Filtrar Produtos</h2>
                </div>
                <!--Filtro por tipo de cabelo-->
                <div class="filter">
                    <h3>Tipo de Cabelo</h3>
                    <label><input type="checkbox" value="Liso" class="hairType">Liso</label>
                    <label><input type="checkbox" value="Ondulado" class="hairType">Ondulado</label>
                    <label><input type="checkbox" value="Cacheado" class="hairType">Cacheado</label>
                    <label><input type="checkbox" value="Crespo" class="hairType">Crespo</label>
                </div>

                <!--Filtro por tipo de produto-->
                <div class="filter">
                    <h3>Tipo de Produto</h3>
                    <label><input type="checkbox" value="Creme de Pentear" class="productType">Creme de Pentear</label>
                    <label><input type="checkbox" value="Shampoo" class="productType">Shampoo</label>
                    <label><input type="checkbox" value="Condicionador" class="productType">Condicionador</label>
                    <label><input type="checkbox" value="Máscara" class="productType">Máscara</label>
                </div>

                <!--Filtro por marca-->
                <div class="filter">
                    <h3>Marca</h3>
                    <label><input type="checkbox" value="Apise" class="hairType">Apise</label>
                    <label><input type="checkbox" value="Widi Care" class="hairType">Widi Care</label>
                    <label><input type="checkbox" value="Lola" class="hairType">Lola</label>
                    <label><input type="checkbox" value="Salon Line" class="hairType">Salon Line</label>
                </div>

                <!--Filtro por preço-->
                <div class="filter">
                    <h3>Faixa de Preço</h3>
                    <label><input type="radio" name="priceType" value="Até R$50,00" class="hairType">Até R$50,00</label>
                    <label><input type="radio" name="priceType" value="R$50,00 ~ R$100,00" class="hairType">R$50,00 ~
                        R$100,00</label>
                    <label><input type="radio" name="priceType" value="R$100,00 ~ R$150,00" class="hairType">R$100,00 ~
                        R$150,00</label>
                    <label><input type="radio" name="priceType" value="Acima de R$150,00" class="hairType">Acima de
                        R$150,00</label>
                </div>
            </div>

            <div class="productSection">
            <h2>Nossos Produtos</h2>
            <div class="products">
                <?php
                $sql = "SELECT * FROM tb_produtos WHERE ativo = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($produto = $result->fetch_assoc()) {
                        echo '
                        <div class="product-card">
                            <img src="../img/apise.png" alt="'.htmlspecialchars($produto["nome"]).'">
                            <p id="product-name">'.htmlspecialchars($produto["nome"]).'</p>
                            <p id="product-brand">'.htmlspecialchars($produto["categoria"]).'</p>
                            <span>R$ '.number_format($produto["preco_venda"] + 10, 2, ',', '.').'</span>
                            <p id="product-price">R$ '.number_format($produto["preco_venda"], 2, ',', '.').'</p>
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
            const priceText = productCard.querySelector('#product-price')?.textContent.replace('R$', '').replace(',', '.').trim();
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