<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_rainhadoouro';

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$qtd_funcionarios = $conn->query("SELECT COUNT(*) as total FROM tb_funcionarios")->fetch_assoc()['total'];
$qtd_produtos = $conn->query("SELECT COUNT(*) as total FROM tb_produtos")->fetch_assoc()['total'];
$qtd_agendamentos = $conn->query("SELECT COUNT(*) as total FROM tb_agendamentos")->fetch_assoc()['total'];

$anoAtual = date('Y');
$mesesNomes = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
$mesesLabel = [];

for ($i = 1; $i <= 12; $i++) {
    $mesesLabel[] = $mesesNomes[$i - 1] . '/' . $anoAtual;
}

$quantidadesVendas = array_fill(0, 12, 0);

$sql = "SELECT MONTH(data_venda) AS mes, COUNT(*) AS total_vendas
        FROM tb_vendas
        WHERE YEAR(data_venda) = $anoAtual
        GROUP BY mes";

$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $indice = (int)$row['mes'] - 1;
        $quantidadesVendas[$indice] = (int)$row['total_vendas'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Rainha do Ouro</title>

    <link rel="stylesheet" href="../css/dashboard_adm.css" />
    <script src="https://unpkg.com/akar-icons-fonts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <aside class="sidebar">
        <div class="left">
            <img src="../img/logo.png" alt="Logo Rainha do Ouro" />
            <div class="test">
                <button><i class="ai-home-alt1"></i></button>
                <div class="texto-hover">Início</div>
            </div>
            <div class="test">
                <button onclick="carregarPagina('../html/consultar_agend.html', '../css/consultarAgendamento.css', '../script/consultar_agendamentos.js')"><i class="ai-calendar"></i></button>
                <div class="texto-hover texto-hover-relatorio">Agenda</div>
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
                    <button onclick="carregarPagina('../html/FormCadastrarFuncionario.html', '../css/funcionario_cadastro.css', '../script/formCadastraFuncionario.js')">
                        <i class="ai-person"></i>
                        <span class="tst">Cadastrar Funcionários</span>
                    </button>

                    <button onclick="carregarPagina('../html/FormCadastrarProduto_Serviço.html', '../css/cadastro_serv-prod.css', '../script2/formCadastraProduto_Serviço.js')">
                        <i class="ai-shipping-box-v1"></i>
                        <span class="tst">Cadastrar Produtos</span>
                    </button>

                    <!-- Exemplo em branco para adicionar novas páginas -->
                    <button onclick="carregarPagina('../Funcionario/consultar_atend.php', null, null)">
                        <i class="ai-file"></i>
                        <span class="tst">Nova Página</span>
                    </button>
                </nav>
            </div>
        </div>
    </aside>

    <div id="conteudo">
        <section class="container-dashboard">
            <div class="resumo-dashboard">
                <div class="card-resumo">
                    <h3>Funcionários</h3>
                    <p><?= $qtd_funcionarios ?></p>
                </div>
                <div class="card-resumo">
                    <h3>Produtos</h3>
                    <p><?= $qtd_produtos ?></p>
                </div>
                <div class="card-resumo">
                    <h3>Agendamentos</h3>
                    <p><?= $qtd_agendamentos ?></p>
                </div>

                <div style="width: 80%; max-width: 800px; margin: 40px auto;">
                    <canvas id="graficoVendas"></canvas>
                </div>
            </div>
        </section>
    </div>

    <script>
        /**
         * Carrega página HTML via fetch e injeta no conteúdo.
         * Pode opcionalmente carregar CSS e JS externos.
         * 
         * @param {string} caminhoPagina URL da página HTML a carregar
         * @param {string|null} caminhoCss URL do CSS externo (opcional)
         * @param {string|null} caminhoJs URL do JS externo (opcional)
         */
        function carregarPagina(caminhoPagina, caminhoCss = null, caminhoJs = null) {
            if (!caminhoPagina) {
                console.warn('Nenhuma página foi especificada para carregar.');
                document.getElementById('conteudo').innerHTML = "<p>Nenhuma página selecionada.</p>";
                return;
            }

            fetch(caminhoPagina)
                .then(res => {
                    if (!res.ok) throw new Error('Erro ao carregar página');
                    return res.text();
                })
                .then(html => {
                    document.getElementById('conteudo').innerHTML = html;

                    // Remove CSS anterior dinâmico se existir
                    if (caminhoCss) {
                        let cssExistente = document.getElementById('css-dinamico');
                        if (cssExistente) cssExistente.remove();

                        const linkCss = document.createElement('link');
                        linkCss.rel = 'stylesheet';
                        linkCss.href = caminhoCss;
                        linkCss.id = 'css-dinamico';
                        document.head.appendChild(linkCss);
                    }

                    // Remove JS anterior dinâmico se existir
                    if (caminhoJs) {
                        let scriptExistente = document.getElementById('js-dinamico');
                        if (scriptExistente) scriptExistente.remove();

                        const script = document.createElement('script');
                        script.src = caminhoJs;
                        script.id = 'js-dinamico';
                        script.onload = () => {
                            console.log('Script carregado com sucesso: ' + caminhoJs);
                        };
                        document.body.appendChild(script);
                    }
                })
                .catch(err => {
                    console.error('Erro ao carregar página:', err);
                    document.getElementById('conteudo').innerHTML = "<p>Erro ao carregar a página.</p>";
                });
        }

        const ctx = document.getElementById('graficoVendas').getContext('2d');
        const graficoVendas = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($mesesLabel) ?>,
                datasets: [{
                    label: 'Quantidade de Vendas',
                    data: <?= json_encode($quantidadesVendas) ?>,
                    backgroundColor: 'rgba(75, 192, 85, 0.7)',
                    borderColor: 'rgba(75, 192, 85, 0.7)',
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
</body>

</html>