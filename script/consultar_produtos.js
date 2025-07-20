
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle filtros avançados
            const advancedFiltersToggle = document.getElementById('advancedFiltersToggle');
            const advancedFilters = document.getElementById('advancedFilters');

            advancedFiltersToggle.addEventListener('change', function() {
                if (this.checked) {
                    advancedFilters.classList.remove('hidden', 'h-0');
                    advancedFilters.classList.add('block', 'h-auto');
                } else {
                    advancedFilters.classList.remove('block', 'h-auto');
                    advancedFilters.classList.add('hidden', 'h-0');
                }
            });

            // Limpar formulário
            const clearButton = document.getElementById('clearButton');
            const searchForm = document.getElementById('searchForm');

            clearButton.addEventListener('click', function() {
                searchForm.reset();
                advancedFiltersToggle.checked = false;
                advancedFilters.classList.remove('block', 'h-auto');
                advancedFilters.classList.add('hidden', 'h-0');
                clearResults();
            });

            // Botão buscar
            const searchButton = document.getElementById('searchButton');
            const resultsBody = document.getElementById('resultsBody');
            const noResults = document.getElementById('noResults');

            searchButton.addEventListener('click', function() {
                // Simula busca com dados mock
                const mockData = generateMockData();
                displayResults(mockData);
            });

            // Carregar com alguns resultados iniciais
            const initialData = generateMockData().slice(0, 5);
            displayResults(initialData);

            // Funções auxiliares
            function clearResults() {
                resultsBody.innerHTML = '';
                noResults.classList.remove('hidden');
                noResults.classList.add('block');
            }

            function displayResults(products) {
                resultsBody.innerHTML = '';

                if (products.length === 0) {
                    noResults.classList.remove('hidden');
                    noResults.classList.add('block');
                    return;
                } else {
                    noResults.classList.remove('block');
                    noResults.classList.add('hidden');
                }

                products.forEach(product => {
                    const row = document.createElement('tr');

                    // Formatar data
                    const updatedDate = new Date(product.lastUpdated);
                    const formattedDate = updatedDate.toLocaleDateString('pt-BR', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });

                    // Classe status
                    const statusClass = product.status === 'active' ?
                        'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';

                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${product.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${product.name}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${product.category}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$${product.price.toFixed(2).replace('.', ',')}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${product.stock}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formattedDate}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                                ${product.status === 'active' ? 'Ativo' : 'Inativo'}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-blue-600 hover:text-blue-900 mr-2">Editar</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Excluir</a>
                        </td>
                    `;

                    resultsBody.appendChild(row);
                });
            }

            // Gerar dados mock (exemplo)
            function generateMockData() {
                return [
                    { id: 1, name: 'Smartphone XYZ', category: 'Eletrônicos', price: 1499.99, stock: 12, lastUpdated: '2025-07-15', status: 'active' },
                    { id: 2, name: 'Camiseta Básica', category: 'Roupas', price: 39.90, stock: 35, lastUpdated: '2025-07-10', status: 'active' },
                    { id: 3, name: 'Cafeteira Elétrica', category: 'Casa e Jardim', price: 299.50, stock: 7, lastUpdated: '2025-06-20', status: 'inactive' },
                    { id: 4, name: 'Perfume Floral', category: 'Produtos de Beleza', price: 89.90, stock: 20, lastUpdated: '2025-07-01', status: 'active' },
                    { id: 5, name: 'Relógio de Pulso', category: 'Acessórios', price: 249.00, stock: 15, lastUpdated: '2025-07-18', status: 'active' },
                    { id: 6, name: 'Chocolate Amargo', category: 'Alimentos e Bebidas', price: 19.90, stock: 50, lastUpdated: '2025-07-16', status: 'active' }
                ];
            }
        });
