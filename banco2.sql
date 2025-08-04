
CREATE SCHEMA IF NOT EXISTS `db_rainhadoouro`;
USE `db_rainhadoouro`;

-- ==============================
-- TABELAS BÁSICAS
-- ==============================

-- Produtos
CREATE TABLE IF NOT EXISTS `tb_produtos` (
  `id_produtos` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  `preco_venda` DECIMAL(10,2) NOT NULL,
  `categoria` VARCHAR(50) NOT NULL,
  `quantidade_estoque` INT NOT NULL,
  `path` VARCHAR(100) NOT NULL,
  `data_upload` DATE NOT NULL,
  PRIMARY KEY (`id_produtos`)
);

-- Serviços
CREATE TABLE IF NOT EXISTS `tb_servicos` (
  `id_servicos` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  `preco` DECIMAL(10,2) NOT NULL,
  `path` VARCHAR(100) NOT NULL,
  `data_upload` DATE NOT NULL,
  PRIMARY KEY (`id_servicos`)
);

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
)

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
  `email` VARCHAR(100) NOT NULL UNIQUE,
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
  `data_cadastro` DATE NOT NULL DEFAULT (CURRENT_DATE),
  PRIMARY KEY (`id_funcionarios`)
)
-- Gerência
CREATE TABLE IF NOT EXISTS `tb_gerencia` (
  `id_gerencias` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `cpf` VARCHAR(14) NOT NULL,
  `cargo` VARCHAR(50),
  PRIMARY KEY (`id_gerencias`)
);

-- ==============================
-- CONTROLE DE ESTOQUE E MOVIMENTAÇÃO
-- ==============================

-- Compras
CREATE TABLE IF NOT EXISTS `tb_compras` (
  `id_compras` INT NOT NULL AUTO_INCREMENT,
  `id_produtos` INT NOT NULL,
  `quantidade` INT NOT NULL,
  `valor_total` DECIMAL(10,2) NOT NULL,
  `data_compra` DATE NOT NULL,
  PRIMARY KEY (`id_compras`),
  FOREIGN KEY (`id_produtos`) REFERENCES `tb_produtos`(`id_produtos`)
);

-- Estoque Atualização
CREATE TABLE IF NOT EXISTS `tb_estoque_atualizacao` (
  `id_estoque_atualizacao` INT NOT NULL AUTO_INCREMENT,
  `id_produtos` INT NOT NULL,
  `quantidade` INT NOT NULL,
  `tipo` VARCHAR(20) NOT NULL,
  `data_atualizacao` DATETIME NOT NULL,
  PRIMARY KEY (`id_estoque_atualizacao`),
  FOREIGN KEY (`id_produtos`) REFERENCES `tb_produtos`(`id_produtos`),
  ON DELETE CASCADE ON UPDATE CASCADE
);

-- ==============================
-- AGENDAMENTOS, VENDAS E PAGAMENTOS
-- ==============================

-- Agendamentos
CREATE TABLE IF NOT EXISTS `tb_agendamentos` (
  `id_agendamentos` INT NOT NULL AUTO_INCREMENT,
  `servico` VARCHAR(60) NOT NULL,
  `tipoServico` VARCHAR(95) NOT NULL,
  `data` DATE NOT NULL,
  `horario` TIME NOT NULL,
  `status` ENUM('agendado', 'realizado', 'cancelado') DEFAULT 'agendado',
  `nome` VARCHAR(255),
  `sobrenome` VARCHAR(255),
  `email` VARCHAR(255),
  `telefone` VARCHAR(20),
    PRIMARY KEY (`id_agendamentos`)
);

-- Vendas
CREATE TABLE IF NOT EXISTS `tb_vendas` (
  `id_vendas` INT NOT NULL AUTO_INCREMENT,
  `id_produtos` INT NOT NULL,
  `quantidade` INT NOT NULL,
  `data_venda` DATE NOT NULL,
  PRIMARY KEY (`id_vendas`),
  FOREIGN KEY (`id_produtos`) REFERENCES `tb_produtos`(`id_produtos`)
);

-- Pagamentos
CREATE TABLE IF NOT EXISTS `tb_pagamentos` (
  `id_pagamentos` INT NOT NULL AUTO_INCREMENT,
  `id_agendamentos` INT NOT NULL,
  `valor_pago` DECIMAL(10,2) NOT NULL,
  `data_pagamento` DATE NOT NULL,
  `forma_pagamento` VARCHAR(50),
  PRIMARY KEY (`id_pagamentos`),
  FOREIGN KEY (`id_agendamentos`) REFERENCES `tb_agendamentos`(`id_agendamentos`)
);

-- ==============================
-- LOGIN
-- ==============================

-- Login geral
CREATE TABLE IF NOT EXISTS `tb_login` (
  `id_login` INT NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(50) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `tipo` ENUM('cliente', 'funcionario') NOT NULL,
  `id_referencia` INT NOT NULL,
  PRIMARY KEY (`id_login`)
);

-- Login gerência
CREATE TABLE tb_login_gerencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    id_funcionario INT,
    FOREIGN KEY (id_funcionario) REFERENCES tb_funcionarios(id_funcionarios)
)

-- ==============================
-- TRIGGERS
-- ==============================

-- Trigger para atualizar estoque após compra
CREATE TRIGGER after_insert_compra
AFTER INSERT ON tb_compras
FOR EACH ROW
BEGIN
  UPDATE tb_produtos
  SET quantidade_estoque = quantidade_estoque + NEW.quantidade
  WHERE id_produtos = NEW.id_produtos;
END;

-- Trigger para atualizar estoque após venda
CREATE TRIGGER after_insert_venda
AFTER INSERT ON tb_vendas
FOR EACH ROW
BEGIN
  UPDATE tb_produtos
  SET quantidade_estoque = quantidade_estoque - NEW.quantidade
  WHERE id_produtos = NEW.id_produtos;
END;
