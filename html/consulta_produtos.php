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

// Importa função auxiliar
require_once 'estoque_utils.php';

// Atualiza estoque via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produto']) && isset($_POST['nova_quantidade'])) {
    $id_produto = intval($_POST['id_produto']);
    $nova_quantidade = intval($_POST['nova_quantidade']);
    if ($id_produto > 0 && $nova_quantidade >= 0) {
        atualizarEstoque($conn, $id_produto, $nova_quantidade);
        echo "<script>alert('Estoque atualizado com sucesso!');</script>";
    }
}

// Leitura dos filtros (GET)
$productName = isset($_GET['productName']) ? trim($_GET['productName']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$status = isset($_GET['status']) ? $_GET['status'] : 'all';
$minQuantity = isset($_GET['minQuantity']) ? intval($_GET['minQuantity']) : null;
$maxQuantity = isset($_GET['maxQuantity']) ? intval($_GET['maxQuantity']) : null;
$updatedFrom = isset($_GET['updatedFrom']) ? $_GET['updatedFrom'] : '';
$updatedTo = isset($_GET['updatedTo']) ? $_GET['updatedTo'] : '';

// Montar query com join entre produtos e estoque
$sql = "SELECT p.id_produtos, p.nome, p.categoria, p.preco_venda, p.ativo, 
               IFNULL(e.quantidade, 0) AS estoque, e.atualizado_em
        FROM tb_produtos p
        LEFT JOIN tb_estoque e ON p.id_produtos = e.tb_produtos_id_produtos
        WHERE 1=1 ";

$params = [];
$types = "";

// Filtros
if ($productName !== '') {
    $sql .= " AND p.nome LIKE ? ";
    $params[] = "%".$productName."%";
    $types .= "s";
}
if ($category !== 'all') {
    $sql .= " AND p.categoria = ? ";
    $params[] = $category;
    $types .= "s";
}
if ($status !== 'all') {
    if ($status === 'active' || $status === 'ativo') {
        $sql .= " AND p.ativo = 1 ";
    } else {
        $sql .= " AND p.ativo = 0 ";
    }
}
if ($minQuantity !== null && $minQuantity >= 0) {
    $sql .= " AND IFNULL(e.quantidade, 0) >= ? ";
    $params[] = $minQuantity;
    $types .= "i";
}
if ($maxQuantity !== null && $maxQuantity >= 0) {
    $sql .= " AND IFNULL(e.quantidade, 0) <= ? ";
    $params[] = $maxQuantity;
    $types .= "i";
}
if ($updatedFrom !== '') {
    $sql .= " AND (e.atualizado_em >= ? OR e.atualizado_em IS NULL) ";
    $params[] = $updatedFrom . " 00:00:00";
    $types .= "s";
}
if ($updatedTo !== '') {
    $sql .= " AND (e.atualizado_em <= ? OR e.atualizado_em IS NULL) ";
    $params[] = $updatedTo . " 23:59:59";
    $types .= "s";
}

$sql .= " ORDER BY p.nome ASC ";

$stmt = $conn->prepare($sql);

if ($types !== '' && count($params) > 0) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$produtos = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Consulta de Produtos</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="../css/consultar_produtos.css">
<style>.hidden { display: none; }</style>
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
                <input type="text" name="productName" id="productName" value="<?= htmlspecialchars($productName) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="all" <?= $category === 'all' ? 'selected' : '' ?>>Todas</option>
                    <option value="Shampoo" <?= $category === 'Shampoo' ? 'selected' : '' ?>>Shampoo</option>
                    <option value="Condicionador" <?= $category === 'Condicionador' ? 'selected' : '' ?>>Condicionador</option>
                    <option value="Máscara" <?= $category === 'Máscara' ? 'selected' : '' ?>>Máscara</option>
                    <option value="Leave-in" <?= $category === 'Leave-in' ? 'selected' : '' ?>>Leave-in</option>
                    <option value="Gel" <?= $category === 'Gel' ? 'selected' : '' ?>>Gel</option>
                    <option value="Óleo" <?= $category === 'Óleo' ? 'selected' : '' ?>>Óleo</option>
                    <option value="Spray" <?= $category === 'Spray' ? 'selected' : '' ?>>Spray</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>Todos</option>
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Ativo</option>
                    <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
        </div>

        <div class="flex items-center mt-4">
            <input type="checkbox" id="advancedFiltersToggle" class="h-4 w-4 text-blue-600 border-gray-300 rounded" />
            <label for="advancedFiltersToggle" class="ml-2 block text-sm text-gray-700 cursor-pointer">Mostrar filtros avançados</label>
        </div>

        <div id="advancedFilters" class="hidden h-0">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4 pt-4 border-t border-gray-200">
                <div>
                    <label for="minQuantity" class="block text-sm font-medium text-gray-700 mb-1">Quantidade Mínima</label>
                    <input type="number" name="minQuantity" id="minQuantity" min="0" value="<?= htmlspecialchars($minQuantity) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                </div>

                <div>
                    <label for="maxQuantity" class="block text-sm font-medium text-gray-700 mb-1">Quantidade Máxima</label>
                    <input type="number" name="maxQuantity" id="maxQuantity" min="0" value="<?= htmlspecialchars($maxQuantity) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                </div>

                <div>
                    <label for="updatedFrom" class="block text-sm font-medium text-gray-700 mb-1">Data de Atualização (De)</label>
                    <input type="date" name="updatedFrom" id="updatedFrom" value="<?= htmlspecialchars($updatedFrom) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                </div>

                <div>
                    <label for="updatedTo" class="block text-sm font-medium text-gray-700 mb-1">Data de Atualização (Até)</label>
                    <input type="date" name="updatedTo" id="updatedTo" value="<?= htmlspecialchars($updatedTo) ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Buscar</button>
            <button type="button" onclick="window.location.href='<?= $_SERVER['PHP_SELF'] ?>'" class="px-4 py-2 border rounded">Limpar</button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-800">Resultados</h2>
    </div>

    <div class="overflow-x-auto" aria-live="polite">
        <table class="min-w-full divide-y divide-gray-200">
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
                    <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $p['id_produtos'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($p['nome']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($p['categoria']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">R$ <?= number_format($p['preco_venda'], 2, ',', '.') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form method="POST" action="" style="display:inline-flex; align-items:center;">
                                    <input type="hidden" name="id_produto" value="<?= $p['id_produtos'] ?>">
                                    <input type="number" name="nova_quantidade" value="<?= $p['estoque'] ?>" min="0" style="width:60px; margin-right:4px; padding:2px;" />
                                    <button type="submit" style="background-color:#2563eb; color:white; border:none; padding:4px 8px; border-radius:4px; cursor:pointer;">Salvar</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $p['atualizado_em'] ? date('d/m/Y H:i', strtotime($p['atualizado_em'])) : '-' ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= $p['ativo'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
</div>

</div>

<script>
document.getElementById('advancedFiltersToggle').addEventListener('change', function() {
    var advFilters = document.getElementById('advancedFilters');
    if(this.checked) {
        advFilters.classList.remove('hidden');
        advFilters.style.height = 'auto';
    } else {
        advFilters.classList.add('hidden');
        advFilters.style.height = '0';
    }
});
</script>

</body>
</html>
