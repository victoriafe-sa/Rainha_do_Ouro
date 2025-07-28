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
  `horario_trabalho` TIME NOT NULL,
  `salario` DECIMAL(10,2) NOT NULL,
  `tipo_contrato` ENUM('CLT', 'Autônomo', 'Freelancer') NOT NULL,
  `carteira_trabalho` VARCHAR(20) NOT NULL,
  `pis` VARCHAR(20) NOT NULL,
  `status` ENUM('Ativo', 'Inativo') NOT NULL DEFAULT ('Ativo'),
  `observacoes` TEXT NOT NULL,
  `data_cadastro` DATE NOT NULL DEFAULT (CURRENT_DATE),
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

ALTER TABLE `db_rainhadoouro`.`tb_agendamentos` 
DROP FOREIGN KEY `fk_agendamento_pagamento`,
DROP FOREIGN KEY `fk_agendamento_funcionario`;
ALTER TABLE `db_rainhadoouro`.`tb_agendamentos` 
DROP COLUMN `tb_pagamentos_id_pagamentos`,
DROP COLUMN `tb_funcionarios_id_funcionarios`,
ADD COLUMN `tipoServico` VARCHAR(95) NOT NULL AFTER `servico`,
ADD COLUMN `data` DATE NOT NULL AFTER `tipoServico`,
ADD COLUMN `hora` TIME NOT NULL AFTER `data`,
CHANGE COLUMN `data_hora` `servico` VARCHAR(60) NOT NULL ,
DROP INDEX `fk_agendamento_pagamento` ,
DROP INDEX `fk_agendamento_funcionario` ;
;
ALTER TABLE `db_rainhadoouro`.`tb_agendamentos` 
CHANGE COLUMN `hora` `horario` TIME NOT NULL ;

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



UPDATE tb_estoque
SET quantidade = 5,
    atualizado_em = NOW()
WHERE tb_produtos_id_produtos = 3;

-- Tabela que armazena as vendas realizadas com data e valor
CREATE TABLE IF NOT EXISTS `tb_vendas` (
  `id_venda` INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único da venda
  `data_venda` DATE NOT NULL,                -- Data em que a venda ocorreu
  `valor` DECIMAL(10,2) NOT NULL             -- Valor total da venda
);


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
