<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_rainhadoouro';

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Consulta de Funcionários</title>
  <link rel="stylesheet" href="../css/consunta_funcionario.css">
</head>
<body>

  <h1>Consulta de Funcionários</h1>
  <h2 class="subtitle">Pesquise e visualize informações dos colaboradores</h2>

  <form class="filter-area" action="#" method="GET" onsubmit="event.preventDefault(); pesquisarFuncionarios();">
    <div class="filters-row">
      <div style="flex:1; min-width: 180px;">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" placeholder="Digite o nome" />
      </div>

      <div style="flex:1; min-width: 160px;">
        <label for="departamento">Departamento</label>
        <select id="departamento" name="departamento">
          <option value="todos" selected>Todos</option>
          <option value="rh">RH</option>
          <option value="comercial">Comercial</option>
          <option value="ti">TI</option>
          <option value="financeiro">Financeiro</option>
        </select>
      </div>

      <div style="flex:1; min-width: 140px;">
        <label for="status">Status</label>
        <select id="status" name="status">
          <option value="todos" selected>Todos</option>
          <option value="ativo">Ativo</option>
          <option value="inativo">Inativo</option>
          <option value="afastado">Afastado</option>
        </select>
      </div>
    </div>

    <div class="advanced-filter">
      <input type="checkbox" id="filtrosAvancados" name="filtrosAvancados" />
      <label for="filtrosAvancados">Mostrar filtros avançados</label>
    </div>

    <div class="advanced-filters-row" id="filtrosAvancadosCampos">
      <div style="flex:1; min-width: 160px;">
        <label for="dataAdmissaoDe">Data de Admissão (De)</label>
        <input type="date" id="dataAdmissaoDe" name="dataAdmissaoDe" />
      </div>

      <div style="flex:1; min-width: 160px;">
        <label for="dataAdmissaoAte">Data de Admissão (Até)</label>
        <input type="date" id="dataAdmissaoAte" name="dataAdmissaoAte" />
      </div>

      <div style="flex:1; min-width: 180px;">
        <label for="cargo">Cargo</label>
        <input type="text" id="cargo" name="cargo" placeholder="Digite o cargo" />
      </div>
    </div>

    <div class="buttons-row">
      <button type="reset" class="clear-btn" onclick="resetFiltrosAvancados()">
        <svg class="icon" viewBox="0 0 24 24">
          <path d="M18 6 L6 18 M6 6 L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Limpar
      </button>

      <button type="submit" class="search-btn">
        <svg class="icon" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none"></circle>
          <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Pesquisar
      </button>
    </div>
  </form>

  <section class="results-area" aria-live="polite" aria-atomic="true">
    <div class="results-header" id="resultCount">0 funcionários encontrados</div>

    <table id="tabelaFuncionarios" role="grid">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Cargo</th>
          <th>Departamento</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="6" class="no-results">Use o formulário acima para pesquisar funcionários</td></tr>
      </tbody>
    </table>
  </section>

<script src="../script/consultar_funcionario.js"></script>
</body>
</html>
