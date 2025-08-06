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
-- Aqui está um INSERT de vendas

INSERT INTO tb_vendas (data_venda, valor) VALUES
('2025-01-05', 100.00),
('2025-01-20', 150.00),
('2025-02-10', 200.00),
('2025-02-25', 180.00),
('2025-03-05', 250.00),
('2025-04-12', 220.00),
('2025-05-03', 300.00),
('2025-06-18', 270.00),
('2025-07-08', 350.00),
('2025-08-01', 400.00);

select * from tb_agendamentos;
-- Inserts para clientes
INSERT INTO tb_clientes (nome, telefone, data_nascimento, email, senha, cep, rua, numero, bairro, cidade, estado, ativo) VALUES
('Ana Silva', '11999990001', '1990-05-15', 'ana.silva@email.com', 'senha123', '01234-567', 'Rua A', 100, 'Bairro 1', 'São Paulo', 'SP', 1),
('Bruno Souza', '11999990002', '1985-10-22', 'bruno.souza@email.com', 'senha123', '01234-568', 'Rua B', 101, 'Bairro 2', 'São Paulo', 'SP', 1),
('Carla Dias', '11999990003', '1992-07-10', 'carla.dias@email.com', 'senha123', '01234-569', 'Rua C', 102, 'Bairro 3', 'São Paulo', 'SP', 1),
('Daniel Costa', '11999990004', '1988-12-01', 'daniel.costa@email.com', 'senha123', '01234-570', 'Rua D', 103, 'Bairro 4', 'São Paulo', 'SP', 1),
('Elisa Martins', '11999990005', '1995-03-20', 'elisa.martins@email.com', 'senha123', '01234-571', 'Rua E', 104, 'Bairro 5', 'São Paulo', 'SP', 1),
('Fábio Lima', '11999990006', '1983-11-05', 'fabio.lima@email.com', 'senha123', '01234-572', 'Rua F', 105, 'Bairro 6', 'São Paulo', 'SP', 1),
('Gabriela Rocha', '11999990007', '1991-06-18', 'gabriela.rocha@email.com', 'senha123', '01234-573', 'Rua G', 106, 'Bairro 7', 'São Paulo', 'SP', 1),
('Henrique Alves', '11999990008', '1987-08-25', 'henrique.alves@email.com', 'senha123', '01234-574', 'Rua H', 107, 'Bairro 8', 'São Paulo', 'SP', 1),
('Isabela Fernandes', '11999990009', '1994-09-30', 'isabela.fernandes@email.com', 'senha123', '01234-575', 'Rua I', 108, 'Bairro 9', 'São Paulo', 'SP', 1),
('João Pereira', '11999990010', '1986-04-12', 'joao.pereira@email.com', 'senha123', '01234-576', 'Rua J', 109, 'Bairro 10', 'São Paulo', 'SP', 1);

-- insert de um fornecedor
INSERT INTO tb_fornecedores (nome, cnpj, telefone, email, endereco) VALUES
('Fornecedor 1', '00.000.000/0001-01', '11999990001', 'fornecedor1@email.com', 'Endereco 1');

--  Inserts para pagamentos
INSERT INTO tb_pagamentos (valor, forma_pagamento, status, data_pagamento, tb_compras_id_compras, tb_clientes_id_clientes) VALUES
(100.00, 'pix', 'pago', '2025-08-01 10:00:00', 1, 1),
(150.00, 'cartao', 'pago', '2025-08-02 11:00:00', 2, 2),
(200.00, 'pix', 'pago', '2025-08-03 12:00:00', 3, 3),
(180.00, 'cartao', 'pago', '2025-08-04 13:00:00', 4, 4),
(250.00, 'pix', 'pago', '2025-08-05 14:00:00', 5, 5),
(220.00, 'cartao', 'pago', '2025-08-06 15:00:00', 6, 6),
(300.00, 'pix', 'pago', '2025-08-07 16:00:00', 7, 7),
(270.00, 'cartao', 'pago', '2025-08-08 17:00:00', 8, 8),
(350.00, 'pix', 'pago', '2025-08-09 18:00:00', 9, 9),
(400.00, 'cartao', 'pago', '2025-08-10 19:00:00', 10, 10);

-- Inserts para agendamentos

INSERT INTO tb_agendamentos (servico, tipoServico, data, horario, status, tb_clientes_id_clientes) VALUES
('Corte de cabelo', 'Corte', '2025-08-10', '09:00:00', 'agendado', 1),
('Penteado com tranças', 'Tranças', '2025-08-10', '10:30:00', 'realizado', 2),
('Hidratação capilar', 'Hidratação', '2025-08-11', '14:00:00', 'cancelado', 3),
('Coloração', 'Coloração', '2025-08-12', '11:00:00', 'agendado', 4),
('Escova modeladora', 'Escova', '2025-08-12', '15:00:00', 'agendado', 5),
('Corte e escova', 'Combo', '2025-08-13', '13:30:00', 'realizado', 6),
('Penteado para festa', 'Penteado', '2025-08-14', '09:00:00', 'agendado', 7),
('Luzes', 'Coloração', '2025-08-14', '16:00:00', 'agendado', 8),
('Manicure e pedicure', 'Beleza', '2025-08-15', '10:00:00', 'realizado', 9),
('Selagem térmica', 'Tratamento', '2025-08-15', '11:30:00', 'agendado', 10),
('Corte masculino', 'Corte', '2025-08-16', '14:00:00', 'agendado', 1),
('Relaxamento', 'Tratamento', '2025-08-16', '15:30:00', 'cancelado', 2),
('Penteado noiva', 'Penteado', '2025-08-17', '09:00:00', 'realizado', 3),
('Reconstrução capilar', 'Tratamento', '2025-08-17', '13:00:00', 'agendado', 4),
('Progressiva', 'Tratamento', '2025-08-18', '10:00:00', 'agendado', 5);

-- insert de compras
INSERT INTO tb_compras (data_compra, valor_total, observacoes, tb_fornecedores_id_fornecedores) VALUES
('2025-08-01 09:00:00', 100.00, 'Compra 1', 1),
('2025-08-02 10:00:00', 150.00, 'Compra 2', 1),
('2025-08-03 11:00:00', 200.00, 'Compra 3', 1),
('2025-08-04 12:00:00', 180.00, 'Compra 4', 1),
('2025-08-05 13:00:00', 250.00, 'Compra 5', 1),
('2025-08-06 14:00:00', 220.00, 'Compra 6', 1),
('2025-08-07 15:00:00', 300.00, 'Compra 7', 1),
('2025-08-08 16:00:00', 270.00, 'Compra 8', 1),
('2025-08-09 17:00:00', 350.00, 'Compra 9', 1),
('2025-08-10 18:00:00', 400.00, 'Compra 10', 1);

-- insert de pagamentos
INSERT INTO tb_pagamentos (valor, forma_pagamento, status, data_pagamento, tb_compras_id_compras, tb_clientes_id_clientes) VALUES
(100.00, 'pix', 'pago', '2025-08-01 10:00:00', 1, 1),
(150.00, 'cartao', 'pago', '2025-08-02 11:00:00', 2, 2),
(200.00, 'pix', 'pago', '2025-08-03 12:00:00', 3, 3),
(180.00, 'cartao', 'pago', '2025-08-04 13:00:00', 4, 4),
(250.00, 'pix', 'pago', '2025-08-05 14:00:00', 5, 5),
(220.00, 'cartao', 'pago', '2025-08-06 15:00:00', 6, 6),
(300.00, 'pix', 'pago', '2025-08-07 16:00:00', 7, 7),
(270.00, 'cartao', 'pago', '2025-08-08 17:00:00', 8, 8),
(350.00, 'pix', 'pago', '2025-08-09 18:00:00', 9, 9),
(400.00, 'cartao', 'pago', '2025-08-10 19:00:00', 10, 10);
