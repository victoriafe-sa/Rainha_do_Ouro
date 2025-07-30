INSERT INTO tb_produtos (nome, descricao, preco_venda, categoria, ativo) VALUES
('Shampoo Hidratante para Cachos', 'Shampoo suave para limpar e hidratar cabelos cacheados, mantendo a definição e maciez.', 29.90, 'Shampoo', 1),
('Condicionador Nutritivo para Cachos', 'Condicionador rico em óleos naturais que nutre profundamente os fios cacheados.', 34.50, 'Condicionador', 1),
('Máscara de Hidratação Profunda Cachos', 'Máscara concentrada para reconstrução e hidratação intensa dos cachos.', 45.00, 'Máscara', 1),
('Creme de Pentear Definição e Controle', 'Creme leve para definir cachos e controlar o frizz durante o dia.', 27.90, 'Leave-in', 1),
('Gel Ativador de Cachos', 'Gel que ativa a forma natural dos cachos sem deixar resíduo.', 24.90, 'Gel', 1),
('Óleo de Argan para Cabelos Cacheados', 'Óleo nutritivo que promove brilho e combate o ressecamento dos cachos.', 39.90, 'Óleo', 1),
('Spray de Brilho para Cachos', 'Spray leve que adiciona brilho e controla o frizz.', 22.00, 'Spray', 1),
('Shampoo Sem Sulfato para Cachos', 'Shampoo livre de sulfatos que limpa delicadamente os cabelos cacheados.', 32.00, 'Shampoo', 1),
('Condicionador Sem Silicone', 'Condicionador que hidrata sem pesar nos fios cacheados.', 35.00, 'Condicionador', 1),
('Máscara Reconstrutora para Cachos Danificados', 'Máscara que reconstrói fios danificados e fortalece os cachos.', 49.90, 'Máscara', 1),
('Leave-in Hidratante', 'Leave-in hidratante para cachos definidos e sem frizz.', 28.50, 'Leave-in', 1),
('Creme Noturno para Cachos', 'Creme para uso noturno que hidrata profundamente durante o sono.', 33.00, 'Creme', 1),
('Gel Fixador para Cachos', 'Gel fixador de longa duração para definição de cachos.', 26.00, 'Gel', 1),
('Óleo de Coco para Cabelos Cacheados', 'Óleo natural que nutre e fortalece os cachos.', 37.90, 'Óleo', 1),
('Máscara de Umectação Profunda', 'Máscara para umectação que revitaliza cabelos secos e quebradiços.', 44.00, 'Máscara', 1),
('Spray Finalizador Anti-Frizz', 'Spray finalizador que controla o frizz e sela as cutículas.', 23.50, 'Spray', 1),
('Shampoo Detox para Cachos', 'Shampoo detox que remove impurezas e resíduos.', 30.00, 'Shampoo', 1),
('Condicionador Reparador', 'Condicionador que repara as pontas e sela a hidratação.', 36.50, 'Condicionador', 1),
('Máscara Hidratante com Babosa', 'Máscara enriquecida com babosa para hidratação natural.', 42.00, 'Máscara', 1),
('Creme de Pentear com Manteiga de Karité', 'Creme que define e hidrata os cachos com manteiga de karité.', 29.90, 'Leave-in', 1),
('Gel Modelador Natural', 'Gel modelador com fixação natural sem ressecar.', 25.00, 'Gel', 1),
('Óleo de Rícino para Crescimento', 'Óleo que auxilia no crescimento saudável dos cachos.', 38.00, 'Óleo', 1),
('Spray Fixador Leve', 'Spray para fixação leve e brilho natural.', 21.00, 'Spray', 1),
('Shampoo Antirresíduo', 'Shampoo que remove resíduos para limpeza profunda.', 31.50, 'Shampoo', 1),
('Condicionador com Proteínas', 'Condicionador enriquecido com proteínas para fortalecer os fios.', 37.00, 'Condicionador', 1),
('Máscara Nutritiva com Óleo de Abacate', 'Máscara nutritiva com óleo de abacate para cachos saudáveis.', 46.00, 'Máscara', 1),
('Creme Leave-in Anti-Frizz', 'Leave-in que controla o frizz e define os cachos.', 28.00, 'Leave-in', 1),
('Gel de Alta Definição', 'Gel que oferece alta definição para cachos duradouros.', 27.50, 'Gel', 1),
('Óleo Essencial de Lavanda', 'Óleo essencial que hidrata e acalma o couro cabeludo.', 40.00, 'Óleo', 1),
('Spray Umidificador de Cachos', 'Spray que umidifica e revigora cachos ressecados.', 22.50, 'Spray', 1),
('Shampoo Suave com Camomila', 'Shampoo suave com extrato de camomila para limpeza delicada.', 29.00, 'Shampoo', 1);
USE db_rainhadoouro;


INSERT INTO `tb_servicos` (`nome`, `descricao`, `preco`, `duracao_min`, `ativo`) VALUES
('Corte Feminino', 'Corte de cabelo feminino com lavagem e finalização', 50.00, 45, 1),
('Corte Masculino', 'Corte de cabelo masculino com lavagem inclusa', 35.00, 30, 1),
('Escova', 'Escova modeladora para todos os tipos de cabelo', 40.00, 40, 1),
('Coloração', 'Coloração completa dos fios com tonalizante ou tinta permanente', 120.00, 90, 1),
('Hidratação Capilar', 'Tratamento profundo para cabelos ressecados', 60.00, 50, 1),
('Manicure', 'Serviço de manicure com esmaltação comum', 25.00, 30, 1),
('Pedicure', 'Serviço de pedicure com remoção de cutículas e esmaltação', 30.00, 35, 1),
('Sobrancelha', 'Design de sobrancelhas com pinça ou cera', 20.00, 20, 1),
('Depilação Axila', 'Depilação das axilas com cera quente', 25.00, 20, 1),
('Progressiva', 'Alisamento capilar com escova progressiva', 180.00, 120, 1);


-- Inserir um fornecedor para usar no teste (se ainda não tiver)
INSERT INTO tb_fornecedores (nome, cnpj, telefone, email, endereco) VALUES
('Fornecedor Teste', '12.345.678/0001-99', '(11) 99999-9999', 'fornecedor@teste.com', 'Rua Teste, 123');

-- Inserir compra associada ao fornecedor (use o ID do fornecedor inserido acima, aqui supondo id = 1)
INSERT INTO tb_compras (data_compra, valor_total, observacoes, tb_fornecedores_id_fornecedores) VALUES
(NOW(), 200.00, 'Compra teste 1', 1);

-- Inserir venda correspondente para refletir no gráfico
INSERT INTO tb_vendas (data_venda, valor) VALUES
(CURDATE(), 200.00);

-- Outra compra e venda para outro teste
INSERT INTO tb_compras (data_compra, valor_total, observacoes, tb_fornecedores_id_fornecedores) VALUES
(NOW(), 350.50, 'Compra teste 2', 1);

INSERT INTO tb_vendas (data_venda, valor) VALUES
(CURDATE(), 350.50);

-- Mais um exemplo de compra e venda com valor diferente
INSERT INTO tb_compras (data_compra, valor_total, observacoes, tb_fornecedores_id_fornecedores) VALUES
(NOW(), 125.75, 'Compra teste 3', 1);

INSERT INTO tb_vendas (data_venda, valor) VALUES
(CURDATE(), 125.75);


INSERT INTO tb_vendas (data_venda, valor) VALUES
('2025-01-15', 120.00),
('2025-01-22', 80.00),
('2025-02-03', 200.00),
('2025-02-15', 90.00),
('2025-03-10', 150.00),
('2025-04-05', 300.00),
('2025-07-01', 450.00);

-- INSERT INTO tb_estoque_atualizacao (tb_produtos_id_produtos, ultima_atualizacao)
-- VALUES (3, NOW())
-- ON DUPLICATE KEY UPDATE ultima_atualizacao = NOW();

