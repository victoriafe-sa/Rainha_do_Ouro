CREATE SCHEMA IF NOT EXISTS `db_rainhadoouro`;
USE `db_rainhadoouro`;

-- Produtos
CREATE TABLE IF NOT EXISTS `tb_produtos` (
  `id_produtos` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  `preco_venda` DECIMAL(10,2) NOT NULL,
  `categoria` VARCHAR(50) NOT NULL,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_produtos`)
) ENGINE = InnoDB;

-- Serviços
CREATE TABLE IF NOT EXISTS `tb_servicos` (
  `id_servicos` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `descricao` TEXT NOT NULL,
  `preco` DECIMAL(10,2) NOT NULL,
  `duracao_min` INT NOT NULL,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_servicos`)
) ENGINE = InnoDB;

-- Fornecedores
CREATE TABLE IF NOT EXISTS `tb_fornecedores` (
  `id_fornecedores` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `cnpj` VARCHAR(25) NOT NULL,
  `telefone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `endereco` TEXT NOT NULL,
  PRIMARY KEY (`id_fornecedores`)
) ENGINE = InnoDB;

-- Estoque
CREATE TABLE IF NOT EXISTS `tb_estoque` (
  `id_estoque` INT NOT NULL AUTO_INCREMENT,
  `quantidade` INT NOT NULL,
  `atualizado_em` DATETIME NOT NULL,
  `tb_fornecedores_id_fornecedores` INT NOT NULL,
  `tb_produtos_id_produtos` INT NOT NULL,
  PRIMARY KEY (`id_estoque`),
  CONSTRAINT `fk_estoque_fornecedor` FOREIGN KEY (`tb_fornecedores_id_fornecedores`) REFERENCES `tb_fornecedores` (`id_fornecedores`) ON DELETE CASCADE,
  CONSTRAINT `fk_estoque_produto` FOREIGN KEY (`tb_produtos_id_produtos`) REFERENCES `tb_produtos` (`id_produtos`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Funcionários
CREATE TABLE IF NOT EXISTS `tb_funcionarios` (
  `id_funcionarios` INT NOT NULL AUTO_INCREMENT,
  `nome_completo` VARCHAR(100) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `cpf` VARCHAR(14) NOT NULL,
  `rg` VARCHAR(20) NOT NULL,
  `sexo` ENUM('Feminino', 'Masculino', 'Outro', 'Prefiro não informar') NOT NULL,
  `estado_civil` ENUM('Solteiro(a)', 'Casado(a)', 'Divorciado(a)', 'Viúvo(a)') NOT NULL,
  `telefone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `cep` VARCHAR(9) NOT NULL,
  `rua` VARCHAR(100) NOT NULL,
  `numero` VARCHAR(10) NOT NULL,
  `bairro` VARCHAR(50) NOT NULL,
  `cidade` VARCHAR(50) NOT NULL,
  `estado` CHAR(2) NOT NULL,
  `cargo` VARCHAR(50) NOT NULL,
  `data_admissao` DATE NOT NULL,
  `horario_trabalho` TIME NOT NULL,
  `salario` DECIMAL(10,2) NOT NULL,
  `tipo_contrato` ENUM('CLT', 'Autônomo', 'Freelancer') NOT NULL,
  `carteira_trabalho` VARCHAR(20) NOT NULL,
  `pis` VARCHAR(20) NOT NULL,
  `status` ENUM('Ativo', 'Inativo') NOT NULL,
  `observacoes` TEXT NOT NULL,
  `data_cadastro` DATETIME NOT NULL,
  PRIMARY KEY (`id_funcionarios`)
) ENGINE = InnoDB;

-- Cabeleireiro
CREATE TABLE IF NOT EXISTS `tb_cabeleireiro` (
  `id_cabeleireiro` INT NOT NULL AUTO_INCREMENT,
  `especialidade` VARCHAR(100) NOT NULL,
  `tb_funcionarios_id_funcionarios` INT NOT NULL,
  PRIMARY KEY (`id_cabeleireiro`),
  CONSTRAINT `fk_cabeleireiro_funcionario` FOREIGN KEY (`tb_funcionarios_id_funcionarios`) REFERENCES `tb_funcionarios` (`id_funcionarios`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Clientes
CREATE TABLE IF NOT EXISTS `tb_clientes` (
  `id_clientes` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60) NOT NULL,
  `telefone` VARCHAR(20) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `cep` VARCHAR(9) NOT NULL,
  `rua` VARCHAR(45) NOT NULL,
  `numero` INT NOT NULL,
  `bairro` VARCHAR(45) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(2) NOT NULL,
  `data_cadastro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_clientes`)
) ENGINE = InnoDB;

-- Carrinho
CREATE TABLE IF NOT EXISTS `tb_carrinho` (
  `id_carrinho` INT NOT NULL AUTO_INCREMENT,
  `data_criacao` DATETIME NULL,
  `status` ENUM('aberto', 'fechado') NULL DEFAULT 'aberto',
  `tb_clientes_id_clientes` INT NOT NULL,
  PRIMARY KEY (`id_carrinho`),
  CONSTRAINT `fk_carrinho_cliente` FOREIGN KEY (`tb_clientes_id_clientes`) REFERENCES `tb_clientes` (`id_clientes`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Itens do Carrinho
CREATE TABLE IF NOT EXISTS `tb_itens_carrinho` (
  `id_itens_carrinho` INT NOT NULL AUTO_INCREMENT,
  `quantidade` INT NOT NULL,
  `tb_carrinho_id_carrinho` INT NOT NULL,
  `tb_produtos_id_produtos` INT NOT NULL,
  PRIMARY KEY (`id_itens_carrinho`),
  CONSTRAINT `fk_itemscarrinho_carrinho` FOREIGN KEY (`tb_carrinho_id_carrinho`) REFERENCES `tb_carrinho` (`id_carrinho`) ON DELETE CASCADE,
  CONSTRAINT `fk_itemscarrinho_produto` FOREIGN KEY (`tb_produtos_id_produtos`) REFERENCES `tb_produtos` (`id_produtos`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Administradores
CREATE TABLE IF NOT EXISTS `tb_administradores` (
  `id_administradores` INT NOT NULL AUTO_INCREMENT,
  `nivel_acesso` INT NOT NULL,
  `tb_funcionarios_id_funcionarios` INT NOT NULL,
  PRIMARY KEY (`id_administradores`),
  CONSTRAINT `fk_admin_funcionario` FOREIGN KEY (`tb_funcionarios_id_funcionarios`) REFERENCES `tb_funcionarios` (`id_funcionarios`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Recepcionista
CREATE TABLE IF NOT EXISTS `tb_recepcionista` (
  `id_recepcionista` INT NOT NULL AUTO_INCREMENT,
  `tb_funcionarios_id_funcionarios` INT NOT NULL,
  PRIMARY KEY (`id_recepcionista`),
  CONSTRAINT `fk_recepcionista_funcionario` FOREIGN KEY (`tb_funcionarios_id_funcionarios`) REFERENCES `tb_funcionarios` (`id_funcionarios`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Compras
CREATE TABLE IF NOT EXISTS `tb_compras` (
  `id_compras` INT NOT NULL AUTO_INCREMENT,
  `data_compra` DATETIME NOT NULL,
  `valor_total` DECIMAL(10,2) NOT NULL,
  `observacoes` TEXT NOT NULL,
  `tb_fornecedores_id_fornecedores` INT NOT NULL,
  PRIMARY KEY (`id_compras`),
  CONSTRAINT `fk_compras_fornecedor` FOREIGN KEY (`tb_fornecedores_id_fornecedores`) REFERENCES `tb_fornecedores` (`id_fornecedores`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Itens da Compra
CREATE TABLE IF NOT EXISTS `tb_itens_compra` (
  `id_itens_compra` INT NOT NULL AUTO_INCREMENT,
  `quantidade` INT NOT NULL,
  `valor_unitario` DECIMAL(10,2) NOT NULL,
  `tb_compras_id_compras` INT NOT NULL,
  `tb_produtos_id_produtos` INT NOT NULL,
  PRIMARY KEY (`id_itens_compra`),
  CONSTRAINT `fk_itenscompra_compras` FOREIGN KEY (`tb_compras_id_compras`) REFERENCES `tb_compras` (`id_compras`) ON DELETE CASCADE,
  CONSTRAINT `fk_itenscompra_produto` FOREIGN KEY (`tb_produtos_id_produtos`) REFERENCES `tb_produtos` (`id_produtos`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Pagamentos
CREATE TABLE IF NOT EXISTS `tb_pagamentos` (
  `id_pagamentos` INT NOT NULL AUTO_INCREMENT,
  `valor` DECIMAL(10,2) NOT NULL,
  `forma_pagamento` ENUM('cartao', 'pix') NOT NULL,
  `status` ENUM('pendente', 'pago', 'cancelado') NOT NULL DEFAULT 'pendente',
  `data_pagamento` DATETIME NOT NULL,
  `tb_compras_id_compras` INT NOT NULL,
  `tb_clientes_id_clientes` INT NOT NULL,
  PRIMARY KEY (`id_pagamentos`),
  CONSTRAINT `fk_pagamento_compra` FOREIGN KEY (`tb_compras_id_compras`) REFERENCES `tb_compras` (`id_compras`) ON DELETE CASCADE,
  CONSTRAINT `fk_pagamento_cliente` FOREIGN KEY (`tb_clientes_id_clientes`) REFERENCES `tb_clientes` (`id_clientes`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Agendamentos
CREATE TABLE IF NOT EXISTS `tb_agendamentos` (
  `id_agendamentos` INT NOT NULL AUTO_INCREMENT,
  `data_hora` DATETIME NULL,
  `status` ENUM('agendado', 'realizado', 'cancelado') NULL DEFAULT 'agendado',
  `tb_funcionarios_id_funcionarios` INT NOT NULL,
  `tb_pagamentos_id_pagamentos` INT NOT NULL,
  PRIMARY KEY (`id_agendamentos`),
  CONSTRAINT `fk_agendamento_funcionario` FOREIGN KEY (`tb_funcionarios_id_funcionarios`) REFERENCES `tb_funcionarios` (`id_funcionarios`) ON DELETE CASCADE,
  CONSTRAINT `fk_agendamento_pagamento` FOREIGN KEY (`tb_pagamentos_id_pagamentos`) REFERENCES `tb_pagamentos` (`id_pagamentos`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Agendamento x Serviços
CREATE TABLE IF NOT EXISTS `tb_agendamento_servicos` (
  `id_agendamento_servico` INT NOT NULL AUTO_INCREMENT,
  `tb_agendamentos_id_agendamentos` INT NOT NULL,
  `tb_servicos_id_servicos` INT NOT NULL,
  PRIMARY KEY (`id_agendamento_servico`),
  CONSTRAINT `fk_agendamento_servico_agendamento` FOREIGN KEY (`tb_agendamentos_id_agendamentos`) REFERENCES `tb_agendamentos` (`id_agendamentos`) ON DELETE CASCADE,
  CONSTRAINT `fk_agendamento_servico_servico` FOREIGN KEY (`tb_servicos_id_servicos`) REFERENCES `tb_servicos` (`id_servicos`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Histórico de Estoque
CREATE TABLE IF NOT EXISTS `tb_historico_estoque` (
  `id_historico` INT NOT NULL AUTO_INCREMENT,
  `tipo_movimentacao` ENUM('entrada', 'saida') NOT NULL,
  `quantidade` INT NOT NULL,
  `data_movimentacao` DATETIME NOT NULL,
  `tb_estoque_id_estoque` INT NOT NULL,
  PRIMARY KEY (`id_historico`),
  CONSTRAINT `fk_historico_estoque`
  FOREIGN KEY (`tb_estoque_id_estoque`) REFERENCES `tb_estoque` (`id_estoque`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Histórico de Agendamentos
CREATE TABLE IF NOT EXISTS `tb_historico_agendamentos` (
  `id_historico_agendamento` INT NOT NULL AUTO_INCREMENT,
  `tb_agendamentos_id_agendamentos` INT NOT NULL,
  `status_anterior` ENUM('agendado', 'realizado', 'cancelado') NOT NULL,
  `status_novo` ENUM('agendado', 'realizado', 'cancelado') NOT NULL,
  `data_alteracao` DATETIME NOT NULL,
  `motivo` TEXT NULL,
  PRIMARY KEY (`id_historico_agendamento`),
  CONSTRAINT `fk_historico_agendamento`
  FOREIGN KEY (`tb_agendamentos_id_agendamentos`) REFERENCES `tb_agendamentos` (`id_agendamentos`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- Histórico de Pagamentos
CREATE TABLE IF NOT EXISTS `tb_historico_pagamentos` (
  `id_historico_pagamento` INT NOT NULL AUTO_INCREMENT,
  `tb_pagamentos_id_pagamentos` INT NOT NULL,
  `descricao` TEXT NOT NULL,
  `valor_anterior` DECIMAL(10,2) NOT NULL,
  `valor_novo` DECIMAL(10,2) NOT NULL,
  `data_alteracao` DATETIME NOT NULL,
  PRIMARY KEY (`id_historico_pagamento`),
  CONSTRAINT `fk_historico_pagamento`
  FOREIGN KEY (`tb_pagamentos_id_pagamentos`) REFERENCES `tb_pagamentos` (`id_pagamentos`) ON DELETE CASCADE
) ENGINE = InnoDB;

INSERT INTO tb_estoque_atualizacao (tb_produtos_id_produtos, ultima_atualizacao)
VALUES (3, NOW())
ON DUPLICATE KEY UPDATE ultima_atualizacao = NOW();

UPDATE tb_estoque
SET quantidade = 5,
    atualizado_em = NOW()
WHERE tb_produtos_id_produtos = 3;


-- produtos
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

-- Tabela que armazena as vendas realizadas com data e valor
CREATE TABLE IF NOT EXISTS `tb_vendas` (
  `id_venda` INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único da venda
  `data_venda` DATE NOT NULL,                -- Data em que a venda ocorreu
  `valor` DECIMAL(10,2) NOT NULL             -- Valor total da venda
);
INSERT INTO tb_vendas (data_venda, valor) VALUES
('2025-01-15', 120.00),
('2025-01-22', 80.00),
('2025-02-03', 200.00),
('2025-02-15', 90.00),
('2025-03-10', 150.00),
('2025-04-05', 300.00),
('2025-07-01', 450.00);

-- Gatilho que insere automaticamente uma venda quando uma nova compra é registrada
DELIMITER //

CREATE TRIGGER after_insert_compra
AFTER INSERT ON tb_compras
FOR EACH ROW
BEGIN
    INSERT INTO tb_vendas (data_venda, valor) 
    VALUES (NEW.data_compra, NEW.valor_total);
END;
//

DELIMITER ;



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
