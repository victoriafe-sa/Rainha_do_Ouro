<?php
// Conexão com o banco de dados
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_rainhadoouro';

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Ler filtros da URL (GET)
$productName = isset($_GET['productName']) ? trim($_GET['productName']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$status = isset($_GET['status']) ? $_GET['status'] : 'all';

// Filtros avançados (opcional)
$minQuantity = isset($_GET['minQuantity']) ? intval($_GET['minQuantity']) : null;
$maxQuantity = isset($_GET['maxQuantity']) ? intval($_GET['maxQuantity']) : null;
$updatedFrom = isset($_GET['updatedFrom']) ? $_GET['updatedFrom'] : '';
$updatedTo = isset($_GET['updatedTo']) ? $_GET['updatedTo'] : '';

// Montar query base e filtros
$sql = "SELECT * FROM tb_produtos WHERE 1=1 ";
$params = [];
$types = "";

// Filtro nome
if ($productName !== '') {
    $sql .= " AND nome LIKE ? ";
    $params[] = "%" . $productName . "%";
    $types .= "s";
}

// Filtro categoria
if ($category !== 'all') {
    $sql .= " AND categoria = ? ";
    $params[] = $category;
    $types .= "s";
}

// Filtro status
if ($status !== 'all') {
    $sql .= " AND status = ? ";
    $params[] = $status;
    $types .= "s";
}

// Filtros avançados
if ($minQuantity !== null && $minQuantity >= 0) {
    $sql .= " AND estoque >= ? ";
    $params[] = $minQuantity;
    $types .= "i";
}
if ($maxQuantity !== null && $maxQuantity >= 0) {
    $sql .= " AND estoque <= ? ";
    $params[] = $maxQuantity;
    $types .= "i";
}
if ($updatedFrom !== '') {
    $sql .= " AND ultima_atualizacao >= ? ";
    $params[] = $updatedFrom;
    $types .= "s";
}
if ($updatedTo !== '') {
    $sql .= " AND ultima_atualizacao <= ? ";
    $params[] = $updatedTo;
    $types .= "s";
}

// Ordenar (opcional, aqui por nome)
$sql .= " ORDER BY nome ASC ";

// Preparar e executar query
$stmt = $conn->prepare($sql);
if ($types && count($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$produtos = $result->fetch_all(MYSQLI_ASSOC);

// Agora você pode usar $produtos para mostrar na tabela HTML, exemplo:
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consulta de Produtos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/consultar_produtos">
</head>
<body class="bg-gray-50 min-h-screen">
<div class="container mx-auto px-4 py-8">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Consulta de Produtos</h1>
        <p class="text-gray-600 mt-2">Busque e visualize as informações dos produtos cadastrados.</p>
    </header>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form id="searchForm" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="productName" class="block text-sm font-medium text-gray-700 mb-1">Nome do Produto</label>
                    <input type="text" name="productName" id="productName" 
                        value="<?= htmlspecialchars($productName) ?>" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                    <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all" <?= $category === 'all' ? 'selected' : '' ?>>Todas</option>
                        <option value="electronics" <?= $category === 'electronics' ? 'selected' : '' ?>>Eletrônicos</option>
                        <option value="clothing" <?= $category === 'clothing' ? 'selected' : '' ?>>Roupas</option>
                        <option value="home" <?= $category === 'home' ? 'selected' : '' ?>>Casa e Jardim</option>
                        <option value="beauty" <?= $category === 'beauty' ? 'selected' : '' ?>>Produtos de Beleza</option>
                        <option value="accessories" <?= $category === 'accessories' ? 'selected' : '' ?>>Acessórios</option>
                        <option value="food" <?= $category === 'food' ? 'selected' : '' ?>>Alimentos e Bebidas</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>Todos</option>
                        <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Ativo</option>
                        <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inativo</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center mt-4">
                <input type="checkbox" id="advancedFiltersToggle" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                <label for="advancedFiltersToggle" class="ml-2 block text-sm text-gray-700 cursor-pointer">Mostrar filtros avançados</label>
            </div>

            <div id="advancedFilters" class="advanced-filters hidden h-0">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4 pt-4 border-t border-gray-200">
                    <div>
                        <label for="minQuantity" class="block text-sm font-medium text-gray-700 mb-1">Quantidade Mínima</label>
                        <input type="number" name="minQuantity" id="minQuantity" min="0" value="<?= htmlspecialchars($minQuantity) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div>
                        <label for="maxQuantity" class="block text-sm font-medium text-gray-700 mb-1">Quantidade Máxima</label>
                        <input type="number" name="maxQuantity" id="maxQuantity" min="0" value="<?= htmlspecialchars($maxQuantity) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div>
                        <label for="updatedFrom" class="block text-sm font-medium text-gray-700 mb-1">Data de Atualização (De)</label>
                        <input type="date" name="updatedFrom" id="updatedFrom" value="<?= htmlspecialchars($updatedFrom) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div>
                        <label for="updatedTo" class="block text-sm font-medium text-gray-700 mb-1">Data de Atualização (Até)</label>
                        <input type="date" name="updatedTo" id="updatedTo" value="<?= htmlspecialchars($updatedTo) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Buscar
                </button>
                <button type="button" id="clearButton" onclick="window.location.href='<?= $_SERVER['PHP_SELF'] ?>'" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Limpar
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-800">Resultados</h2>
        </div>

        <div class="table-container overflow-x-auto" aria-live="polite">
            <table id="resultsTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID do Produto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço de Venda</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Atualização</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (count($produtos) > 0): ?>
                        <?php foreach($produtos as $p): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $p['id_produto'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($p['nome']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($p['categoria']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">R$ <?= number_format($p['preco_venda'], 2, ',', '.') ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $p['estoque'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= date('d/m/Y', strtotime($p['ultima_atualizacao'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= ($p['status'] === 'active' || $p['status'] === 'ativo') ? 'Ativo' : 'Inativo' ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Aqui você pode colocar botões de ação, editar, excluir -->
                                    <a href="#" class="text-blue-600 hover:text-blue-900">Editar</a>
                                    <a href="#" class="text-red-600 hover:text-red-900 ml-3">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Nenhum resultado para os filtros aplicados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Aqui você pode implementar paginação se quiser -->
    </div>
</div>

<script src="../script/consultar_produtos.js"></script>
</body>
</html>
<?php
$conn->close();
?>