<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aqui você pode tratar os dados do formulário
    $servico = $_POST['service'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';

    // Exemplo de debug:
    // echo "Serviço: $servico, Nome: $nome, Email: $email";
    // Você pode salvar no banco, enviar email, etc.

    //**_______________________________________________________________________________________**/
    //**_______________________________________________________________________________________**/
    //Pagina pronta para lincar com o banco de dados qualquer erro contactar a Rômulo lindo César
    //**_______________________________________________________________________________________**/
    //**_______________________________________________________________________________________**/
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento - Salão Rainha do Ouro</title>
    <link rel="stylesheet" href="../css/agendamentos.css">
    <link rel="stylesheet" href="../css/dahboard_adm.css">
    <script src="https://unpkg.com/akar-icons-fonts"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../img/logo.png" alt="Rainha do Ouro">
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Serviços</a></li>
                <li><a href="../html/produtos.html">Produtos</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="#"><img src="../img/lupa.png" alt="Buscar"></a>
            <a href="#"><img src="../img/carrinho.png" alt="Carrinho"></a>
            <a href="#"><img src="../img/perfil.png" alt="Perfil"></a>
        </div>
    </header>

    <div id="sidebar-container"></div>

    <div class="container">
        <h2>Selecione o tipo de serviço</h2>
        <p>Preencha o formulário com <span class="phone">suas informações</span></p>

        <div class="progress-bar">
            <div class="step active"></div>
            <div class="step"></div>
            <div class="step"></div>
            <div class="step"></div>
        </div>

        <form id="quoteForm" method="POST">
            <!-- Step 1 -->
            <div class="form-step active">
                <h3>Selecione o Serviço</h3>
                <div class="service-options">
                    <?php
                    $servicos = ['Trança', 'Tratamento', 'Consultoria', 'Higienização', 'Corte', 'Manutenção'];
                    foreach ($servicos as $index => $nome) {
                        $checked = $index === 0 ? 'checked' : '';
                        $active = $index === 0 ? 'active' : '';
                        echo "
                        <label class='service $active'>
                            <input type='radio' name='service' value='$nome' $checked>
                            <span>$nome</span>
                        </label>";
                    }
                    ?>
                </div><br>
                <button type="button" class="next-btn">Próximo</button>
            </div>

            <!-- Step 2 -->
            <div class="form-step">
                <h3>Detalhes do Serviço</h3>
                <div id="step2-dynamic-content">
                    <!-- Conteúdo dinâmico com JS -->
                </div>
                <div class="button-group">
                    <button type="button" class="prev-btn">Anterior</button>
                    <button type="button" class="next-btn">Próximo</button>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="form-step">
                <h3>Dados Pessoais</h3>
                <input type="text" name="nome" placeholder="Nome *" required>
                <input type="text" name="sobrenome" placeholder="Sobrenome *" required>
                <input type="email" name="email" placeholder="Email *" required>
                <input type="tel" name="telefone" placeholder="Telefone *" required>
                <div class="button-group">
                    <button type="button" class="prev-btn">Anterior</button>
                    <button type="submit" class="submit-btn">Enviar</button>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="form-step success">
                <h3>Sucesso!</h3>
                <p>Obrigada por agendar com a gente.<br>Uma confirmação do agendamento será enviada para seu email.</p>
                <div class="checkmark">✔</div>
            </div>
        </form>
    </div>

    <script src="../script/dahboard_adm.js"></script>
    <script src="../script/agendamentos.js"></script>
</body>

</html>
