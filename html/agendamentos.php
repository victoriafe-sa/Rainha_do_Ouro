<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    // Redireciona para login com retorno garantido à página de pagamento
    header("Location: user_login.php?redirect=../html/agendamentos.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento | Rainha do Ouro</title>
    <link rel="stylesheet" href="../css/agendamentos.css">
    <link rel="stylesheet" href="../css/dahboard_adm.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
    <script src="https://unpkg.com/akar-icons-fonts"></script>
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
                <li><a href="../html/agendamentos.php">Agendar</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="../html/carrinho.html"><img src="../img/carrinho.png" alt="Carrinho"></a>
            <a href="../html/perfil_usuario.html"><img src="../img/perfil.png" alt="Perfil"></a>
        </div>
    </header>
    <div id="sidebar-container"></div>
    <div class="container">
        <h2>Selecione o tipo de serviço</h2>
        <p>Preencha o formulário com <span class="phone">suas informações</span>
        <div class="progress-bar">
            <div class="step active"></div>
            <div class="step"></div>
            <div class="step"></div>
            <div class="step"></div>
        </div>

        <form id="quoteForm" action="enviar.php" method="post">
            <!-- Step 1 -->
            <div class="form-step active">
                <h3>Selecione o Serviço</h3>
                <div class="service-options">
                    <label class="service active">
                        <input type="radio" name="service" value="Trança" checked>
                        <span>Trança</span>
                    </label>
                    <label class="service">
                        <input type="radio" name="service" value="Tratamento">
                        <span>Tratamento</span>
                    </label>
                    <label class="service">
                        <input type="radio" name="service" value="Consultoria">
                        <span>Consultoria</span>
                    </label>
                    <label class="service">
                        <input type="radio" name="service" value="Higienização">
                        <span>Higienização</span>
                    </label>
                    <label class="service">
                        <input type="radio" name="service" value="Corte">
                        <span>Corte</span>
                    </label>
                    <label class="service">
                        <input type="radio" name="service" value="Manutenção">
                        <span>Manutenção</span>
                    </label>
                </div><br>
                <button type="button" class="next-btn">Próximo</button>
            </div>


            <!-- Step 2 -->
            <div class="form-step">
                <h3>Detalhes do Serviço</h3>
                <div id="step2-dynamic-content">
                    <!-- Conteúdo será inserido dinamicamente com JavaScript -->
                    <label>Selecione a Data *</label>
                    <input type="date" name="data" id="data" required>

                    <label>Selecione o Horário *</label>
                    <select name="horario" required>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                    </select>
                </div>
                <div class="button-group">
                    <button type="button" class="prev-btn">Anterior</button>
                    <button type="button" class="next-btn" onclick="verificarData()">Próximo</button>
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
                    <button type="submit" onclick="document.getElementById('quoteForm').submit();">Enviar</button>

                </div>
            </div>

            <!-- Step 4 -->
            <div class="form-step success">
                <h3>Succeso!</h3>
                <p>Obrigada por agendar com a gente.<br>Uma confirmação do agendamento será enviada para seu email.
                </p>
                <div class="checkmark">✔</div>
            </div>
        </form>
    </div>

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
      
    <script src="../script/dahboard_adm.js"></script>
    <script src="../script/agendamentos.js"></script>
</body>
</html>