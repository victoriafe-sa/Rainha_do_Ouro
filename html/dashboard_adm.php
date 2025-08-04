<?php
// Configurações da conexão com o banco de dados
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_rainhadoouro';

// Cria a conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica se a conexão falhou
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Consultas para contar registros das tabelas
$qtd_funcionarios = $conn->query("SELECT COUNT(*) as total FROM tb_funcionarios")->fetch_assoc()['total'];
$qtd_produtos = $conn->query("SELECT COUNT(*) as total FROM tb_produtos")->fetch_assoc()['total'];
$qtd_agendamentos = $conn->query("SELECT COUNT(*) as total FROM tb_agendamentos")->fetch_assoc()['total'];

// Preparação dos dados para o gráfico de vendas mensais
$anoAtual = date('Y'); // Ano atual para filtro da consulta

// Nomes dos meses para mostrar no gráfico
$mesesNomes = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

// Array para armazenar os labels do gráfico, ex: "Jan/2025"
$mesesLabel = [];
for ($i = 1; $i <= 12; $i++) {
    $mesesLabel[] = $mesesNomes[$i - 1] . '/' . $anoAtual;
}

// Inicializa array para quantidade de vendas em cada mês, inicialmente zero
$quantidadesVendas = array_fill(0, 12, 0);

// Consulta para obter a quantidade de vendas por mês no ano atual
$sql = "SELECT MONTH(data_venda) AS mes, COUNT(*) AS total_vendas
        FROM tb_vendas
        WHERE YEAR(data_venda) = $anoAtual
        GROUP BY mes";

$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Ajusta o índice do mês para preencher o array (meses 1 a 12 => índices 0 a 11)
        $indice = (int)$row['mes'] - 1;
        $quantidadesVendas[$indice] = (int)$row['total_vendas'];
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Rainha do Ouro</title>

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../css/dashboard_adm.css" />

    <!-- Ícones Akar -->
    <script src="https://unpkg.com/akar-icons-fonts"></script>

    <!-- Chart.js para gráficos -->
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
                <button onclick=""><i class="ai-calendar"></i></button>
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
                    <button onclick="carregarPagina('FormCadastrarProduto_Serviço.html')">
                        <i class="ai-shipping-box-v1"></i>
                        <span class="tst">Cadastrar Produtos</span>
                    </button>
                    <button onclick="carregarPagina('FormCadastrarFuncionario.html')">
                        <i class="ai-person"></i>
                        <span class="tst">Cadastrar Funcionario</span>
                    </button>
                </nav>
            </div>
        </div>
    </aside>

    <div id="conteudo">
        <section class="container-dashboard">
            <div class="resumo-dashboard">
                <!-- Cards de resumo -->
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

                <!-- Container do gráfico de vendas mensais -->
                <div style="width: 80%; max-width: 800px; margin: 40px auto;">
                    <canvas id="graficoVendas"></canvas>
                </div>
            </div>
        </section>
    </div>

    <script src="../script/dashboard_adm.js"></script>
    <script src="../script/funcionario_cadastro.js"></script>
    <script src="../script/cad_prod_serv.js"></script>
    

    <script>
        // Seleciona o canvas para o gráfico
        const ctx = document.getElementById('graficoVendas').getContext('2d');

        // Configuração e criação do gráfico de barras com Chart.js
        const graficoVendas = new Chart(ctx, {
            type: 'bar', // tipo do gráfico
            data: {
                labels: <?= json_encode($mesesLabel) ?>, // meses exibidos no eixo X
                datasets: [{
                    label: 'Quantidade de Vendas',
                    data: <?= json_encode($quantidadesVendas) ?>, // valores do eixo Y
                    backgroundColor: 'rgba(75, 192, 85, 0.7)', // cor das barras
                    borderColor: 'rgba(75, 192, 85, 0.7)', // cor da borda das barras
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 40 // largura máxima das barras
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1, // passo do eixo Y
                            precision: 0 // números inteiros no eixo Y
                        }
                    }
                },
                plugins: {
                    legend: { display: true }, // exibe legenda
                    tooltip: { enabled: true } // exibe tooltip ao passar o mouse
                }
            }
        });

        // Função para carregar páginas via fetch (mantida do seu código)
        function carregarPagina(caminho) {
            fetch(caminho)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('conteudo').innerHTML = html;

                    if (caminho.includes('cadastro_serv-prod.html')) {
                        const script = document.createElement('script');
                        script.src = '../script/cadastro_serv-prod.js';
                        script.defer = true;
                        document.body.appendChild(script);
                    }
                })
                .catch(() => {
                    document.getElementById('conteudo').innerHTML = "<p>Erro ao carregar a página.</p>";
                });
        }

        
    </script>
</body>

</html>
