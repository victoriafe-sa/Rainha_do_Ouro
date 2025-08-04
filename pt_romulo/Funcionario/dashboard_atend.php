<?php
session_start();
include("../conectarbd.php"); // Ajuste o caminho conforme sua estrutura

// Controle simples para só deixar entrar quem for atendente:
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'atendente') {
    header('Location: ../login_adm/login_adm.php'); // Ou outra página de login/erro
    exit;
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
    <title>Dashboard Atendente - Rainha do Ouro</title>

    <link rel="stylesheet" href="../css/dashboard_cabel.css" />
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
                <button onclick="carregarPagina('agendamentos.php')"><i class="ai-calendar"></i></button>
                <div class="texto-hover texto-hover-relatorio">Agendamentos</div>
            </div>
            <div class="test">
                <button onclick="carregarPagina('vendas.php')"><i class="ai-shopping-cart"></i></button>
                <div class="texto-hover">Vendas</div>
            </div>
            <div class="test">
                <button onclick="carregarPagina('../Produto_Servico/FormCadastrarProduto_Serviço.html', '../css/prod_serv_php.css')"><i class="ai-shipping-box-v1"></i></button>
                <div class="texto-hover">Cadastrar Produtos</div>
            </div>
        </div>

        <div class="right">
            <div class="right-inner">
                <div class="header">
                    <div>
                        <h2>Bem-vindo, Atendente!</h2>
                        <h3>Sistema de Gerenciamento</h3>
                    </div>
                </div>
                <nav>
                    <!-- Navegação adicional se desejar -->
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
        function carregarPagina(caminhoPagina, caminhoCss = null) {
            fetch(caminhoPagina)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('conteudo').innerHTML = html;

                    // Carrega CSS se houver
                    if (caminhoCss) {
                        let cssExistente = document.getElementById('css-dinamico');
                        if (cssExistente) cssExistente.remove();

                        const linkCss = document.createElement('link');
                        linkCss.rel = 'stylesheet';
                        linkCss.href = caminhoCss;
                        linkCss.id = 'css-dinamico';
                        document.head.appendChild(linkCss);
                    }

                    // ⚠ IMPORTANTE: recarrega JS manualmente após o HTML ser injetado
                    if (caminhoPagina.includes('FormCadastrarProduto_Serviço.html')) {
                        const script = document.createElement('script');
                        script.src = '../script/formCadastraProduto_Serviço.js';
                        script.onload = () => {
                            console.log('Script do formulário carregado com sucesso!');
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
                    legend: { display: true },
                    tooltip: { enabled: true }
                }
            }
        });
    </script>
</body>
</html>
