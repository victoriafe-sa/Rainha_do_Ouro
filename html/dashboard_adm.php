<?php
// Conexão com banco
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_rainhadoouro';

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Dados para os cards resumo
$qtd_funcionarios = $conn->query("SELECT COUNT(*) as total FROM tb_funcionarios")->fetch_assoc()['total'];
$qtd_produtos = $conn->query("SELECT COUNT(*) as total FROM tb_produtos")->fetch_assoc()['total'];
$qtd_agendamentos = $conn->query("SELECT COUNT(*) as total FROM tb_agendamentos")->fetch_assoc()['total'];

// Dados para o gráfico de vendas do ano atual
$anoAtual = date('Y');
$mesesNomes = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
$mesesLabel = [];
for ($i = 1; $i <= 12; $i++) {
    $mesesLabel[] = $mesesNomes[$i - 1] . '/' . $anoAtual;
}

$quantidadesVendas = array_fill(0, 12, 0);
$sql = "SELECT MONTH(data_venda) AS mes, SUM(valor) AS total_vendas
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

// Serviços mais agendados
$sqlServicos = "SELECT servico, COUNT(*) as qtd FROM tb_agendamentos GROUP BY servico ORDER BY qtd DESC LIMIT 5";
$resultServ = $conn->query($sqlServicos);
$servicosMaisAgendados = [];
if ($resultServ) {
    while ($row = $resultServ->fetch_assoc()) {
        $servicosMaisAgendados[] = $row;
    }
}

$conn->close();


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard | Rainha do Ouro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../css/dashboard_adm.css" />
    <script src="https://unpkg.com/akar-icons-fonts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="shortcut icon" type="imagex/png" href="../img/RAINHA DO OURO.ico">
</head>

<body>
    <aside class="sidebar">
        <div class="left">
            <img src="../img/logo.png" alt="Logo Rainha do Ouro" />
            <div class="test">
                <button
                    onclick="carregarPagina('../html/consultar_agend.php', '../css/consultarAgendamento.css', '../script/consultar_agendamentos.js')"><i
                        class="ai-calendar"></i></button>
                <div class="texto-hover texto-hover-relatorio">Agenda</div>
            </div>
            <div class="test btn-exit">
                <button onclick="logout()"><i class="ai-door"></i></button>
                <div class="texto-hover texto-hover-exit">Exit</div>
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
                    <button
                        onclick="carregarPagina('../html/FormCadastrarFuncionario.html', '../css/cadastro.css', '../script/funcionario_cadastro.js')">
                        <i class="ai-person"></i>
                        <span class="tst">Cadastrar Funcionários</span>
                    </button>
                    <button onclick="carregarPagina('../html/FormCadastrarClientes.html', '../css/cadastro.css', '../script/cadastrar_cliente.js')">
                        <i class="ai-file"></i>
                        <span class="tst">Cadastrar Cliente </span>
                    </button>
                    <button
                        onclick="carregarPagina('../html/FormCadastrarProduto_Serviço.html', '../css/cadastro_serv-prod.css', '../script/cad_prod_serv.js')">
                        <i class="ai-shipping-box-v1"></i>
                        <span class="tst">Cadastrar Produtos e Serviço</span>
                    </button>
                    <button onclick="carregarPagina('../crud/FormConsultarFuncionario.php','../css/consultar.css')">
                        <i class="ai-file"></i>
                        <span class="tst">Consulta Funcionario</span>
                    </button>
                    <button onclick="carregarPagina('../crud/FormConsultarClientes.php','../css/consultar.css')">
                        <i class="ai-file"></i>
                        <span class="tst">Consulta Cliente</span>
                    </button>
                    <button onclick="carregarPagina('../crud/FormConsultarProduto.php','../css/consultar.css')">
                        <i class="ai-file"></i>
                        <span class="tst">Consulta Produto</span>
                    </button>
                    <button onclick="carregarPagina('../crud/FormConsultarServico.php','../css/consultar.css')">
                        <i class="ai-file"></i>
                        <span class="tst">Consulta Serviço</span>
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

                <div class="servicos-top" style="width: 80%; max-width: 800px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <h3 style="margin-bottom: 20px;">Top 5 Serviços Mais Agendados</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #eee;">
                                <th style="text-align: left; padding: 10px;">Serviço</th>
                                <th style="text-align: right; padding: 10px;">Agendamentos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($servicosMaisAgendados as $s): ?>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 10px;"><?= htmlspecialchars($s['servico']) ?></td>
                                    <td style="text-align: right; padding: 10px;"><b><?= $s['qtd'] ?></b></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <script>
        function carregarPagina(caminhoPagina, caminhoCss = null, caminhoJs = null) {
            if (!caminhoPagina) {
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

                    if (caminhoCss) {
                        const cssExistente = document.getElementById('css-dinamico');
                        if (cssExistente) cssExistente.remove();

                        const linkCss = document.createElement('link');
                        linkCss.rel = 'stylesheet';
                        linkCss.href = caminhoCss;
                        linkCss.id = 'css-dinamico';
                        document.head.appendChild(linkCss);
                    }

                    if (caminhoJs) {
                        const scriptExistente = document.getElementById('js-dinamico');
                        if (scriptExistente) scriptExistente.remove();

                        const script = document.createElement('script');
                        script.src = caminhoJs;
                        script.id = 'js-dinamico';
                        document.body.appendChild(script);
                    }
                })
                .catch(err => {
                    console.error('Erro ao carregar página:', err);
                    document.getElementById('conteudo').innerHTML = "<p>Erro ao carregar a página.</p>";
                });
        }

        // Inicializa gráfico
        const ctx = document.getElementById('graficoVendas')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($mesesLabel) ?>,
                    datasets: [{
                        label: 'Faturamento Mensal (R$)',
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
        }

        function logout() {
            window.location.href = '../crud/logout_adm.php';
        }
    </script>
</body>

</html>