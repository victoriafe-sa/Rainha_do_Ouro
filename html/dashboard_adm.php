<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sidebars</title>
    <link rel="stylesheet" href="../css/dahboard_adm.css" />
    <script src="https://unpkg.com/akar-icons-fonts"></script>
</head>

<body>
    <aside class="sidebar">
        <div class="left">
            <img src="../img/logo.png" />
            <div class="test">
                <button><i class="ai-home-alt1"></i></button>
                <div class="texto-hover">Início</div>
            </div>
            <div class="test">
                <button><i class="ai-align-left"></i></button>
                <div class="texto-hover texto-hover-grafico">Gráficos</div>
            </div>
            <div class="test">
                <button onclick="carregarPagina('agendamentos.html')"><i class="ai-calendar"></i></button>
                <div class="texto-hover texto-hover-relatorio">Agenda</div>
            </div>
            <div class="test">
                <button><i class="ai-chat-dots"></i></button>
                <div class="texto-hover texto-hover-mensagem">Chat</div>
            </div>
            <div class="test">
                <button><i class="ai-person-check"></i></button>
                <div class="texto-hover texto-hover-user">Usuário</div>
            </div>
            <div>
                <div class="test">
                    <button><i class="ai-gear"></i></button>
                    <div class="texto-hover texto-hover-config">Config</div>
                </div>
                <div class="test">
                    <button><i class="ai-door"></i></button>
                    <div class="texto-hover texto-hover-exit">Exit</div>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="right-inner">
                <div class="header">
                    <div>
                        <h2>Bem-vindo!</h2>
                        <h3>Sistema de Gerenciamento</h3>
                    </div>
                </div>
                <nav>
                    <button onclick="carregarPagina('cadastro_serv-prod.html')">
                        <i class="ai-shipping-box-v1"></i>
                        <span class="tst">Cadastrar Produtos</span>
                    </button>
                    <button onclick="carregarPagina('funcionario_cadastro.html')">
                        <i class="ai-person"></i>
                        <span class="tst">Cadastrar Gerente</span>
                    </button>
                    <button class="button_ai-open-envelope">
                        <i class="ai-open-envelope"></i>
                        <span class="tst">Mensagens</span>
                        <i class="ai-circle-chevron-down-fill arrow-icon"></i>
                    </button>
                    <ul class="submenu">
                        <li>
                            Suporte
                            <span class="badge">10</span>
                        </li>
                        <li>
                            Equipe
                            <span class="badge">4</span>
                        </li>
                        <li>
                            Clientes
                            <span class="badge">20</span>
                        </li>
                    </ul>
                    <button>
                        <i class="ai-data"></i>
                        <span class="tst">Inventory</span>
                    </button>
                </nav>
            </div>
        </div>
    </aside>
    <div id="conteudo"></div>

    <script src="../script/dahboard_adm.js"></script>
</body>

</html>
