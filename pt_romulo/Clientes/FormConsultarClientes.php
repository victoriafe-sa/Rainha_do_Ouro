<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Consultar Clientes</title>
    <link rel="stylesheet" href="../css/consultar.css" />
</head>
<body>

    <main class="container">
      <h1>Consultar Clientes Cadastrados</h1>

      <div class="search-container">
        <input type="search" id="searchInput" placeholder="Buscar por nome, email ou telefone..." />
      </div>

      <div class="table-wrapper">
        <table id="clientesTable" aria-label="Tabela de clientes cadastrados">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Telefone</th>
              <th>Data Nasc.</th>
              <th>Email</th>
              <th>Senha</th>
              <th>CEP</th>
              <th>Rua</th>
              <th>Número</th>
              <th>Bairro</th>
              <th>Cidade</th>
              <th>Estado</th>
              <th>Data Cadastro</th>
              <th>Ativo</th>
              <th>Editar</th>
              <th>Excluir</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include("../conectarbd.php");
            $selecionar = mysqli_query($conn, "SELECT * FROM tb_clientes ORDER BY id_clientes ASC");
            while ($campo = mysqli_fetch_array($selecionar)) {
                echo "<tr>";
                echo "<td>{$campo['id_clientes']}</td>";
                echo "<td>" . htmlspecialchars($campo['nome']) . "</td>";
                echo "<td>" . htmlspecialchars($campo['telefone']) . "</td>";
                echo "<td>" . date('d/m/Y', strtotime($campo['data_nascimento'])) . "</td>";
                echo "<td>" . htmlspecialchars($campo['email']) . "</td>";
                echo "<td>********</td>";
                echo "<td>" . htmlspecialchars($campo['cep']) . "</td>";
                echo "<td>" . htmlspecialchars($campo['rua']) . "</td>";
                echo "<td>" . htmlspecialchars($campo['numero']) . "</td>";
                echo "<td>" . htmlspecialchars($campo['bairro']) . "</td>";
                echo "<td>" . htmlspecialchars($campo['cidade']) . "</td>";
                echo "<td>" . htmlspecialchars($campo['estado']) . "</td>";
                echo "<td>" . date('d/m/Y H:i', strtotime($campo['data_cadastro'])) . "</td>";
                echo "<td>" . ($campo['ativo'] == 1 ? 'Sim' : 'Não') . "</td>";

                $id = $campo['id_clientes'];
                echo "<td><a href='FormEditarClientes.php?editarid=$id' class='btn edit' title='Editar cliente'><svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='none' stroke='#fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M12 20h9'/><path d='M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z'/></svg></a></td>";

                echo "<td><button class='btn delete' data-id='$id' title='Excluir cliente'><svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='none' stroke='#fff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash'><polyline points='3 6 5 6 21 6'/><path d='M19 6l-2 14H7L5 6'/><path d='M10 11v6'/><path d='M14 11v6'/></svg></button></td>";

                echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

      <div id="pagination" class="pagination"></div>

      <a href="../index.php" class="btn btn-cancelar">Cancelar</a>
    </main>

    <!-- Modal Exclusão -->
    <div id="modalDelete" class="modal hidden" role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-describedby="modalDesc">
      <div class="modal-content">
        <h2 id="modalTitle">Confirmar Exclusão</h2>
        <p id="modalDesc">Tem certeza que deseja excluir este cliente?</p>
        <div class="modal-buttons">
          <button id="confirmDelete" class="btn delete">Excluir</button>
          <button id="cancelDelete" class="btn">Cancelar</button>
        </div>
      </div>
    </div>

    <script src="../script/consultar_cliente.js"></script>
</body>
</html>
