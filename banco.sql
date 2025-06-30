-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_rainhadoouro
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_rainhadoouro
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_rainhadoouro` ;
USE `db_rainhadoouro` ;

-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_produtos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_produtos` (
  `id_produtos` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  `preco_venda` DECIMAL(10,2) NOT NULL,
  `categoria` VARCHAR(50) NOT NULL,
  `ativo` INT NOT NULL,
  PRIMARY KEY (`id_produtos`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_servicos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_servicos` (
  `id_servicos` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `descricao` TEXT NOT NULL,
  `preco` DECIMAL(10,2) NOT NULL,
  `duracao_min` INT NOT NULL,
  `ativo` TINYINT NOT NULL,
  PRIMARY KEY (`id_servicos`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_estoque`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_estoque` (
  `id_estoque` INT NOT NULL AUTO_INCREMENT,
  `quantidade` INT NOT NULL,
  `atualizado_em` DATETIME NOT NULL,
  PRIMARY KEY (`id_estoque`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_fornecedores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_fornecedores` (
  `id_fornecedores` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `cnpj` VARCHAR(25) NOT NULL,
  `telefone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `endereco` TEXT NOT NULL,
  PRIMARY KEY (`id_fornecedores`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_cabeleireiro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_cabeleireiro` (
  `id_cabeleireiro` INT NOT NULL AUTO_INCREMENT,
  `especialidade` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_cabeleireiro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_carrinho` (
  `id_carrinho` INT NOT NULL AUTO_INCREMENT,
  `data_criacao` DATETIME NULL,
  `status` ENUM('aberto', 'fechado') NULL,
  PRIMARY KEY (`id_carrinho`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_itens_carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_itens_carrinho` (
  `id_itens_carrinho` INT NOT NULL AUTO_INCREMENT,
  `quantidade` INT NOT NULL,
  PRIMARY KEY (`id_itens_carrinho`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_clientes` (
  `id_clientes` INT NOT NULL,
  `nome` VARCHAR(60) NOT NULL,
  `telefone` VARCHAR(20) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `cep` VARCHAR(12) NOT NULL,
  `rua` VARCHAR(45) NOT NULL,
  `numero` INT NOT NULL,
  `bairro` VARCHAR(45) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(2) NOT NULL,
  `data_cadastro` DATE NOT NULL,
  `ativo` TINYINT NOT NULL,
  PRIMARY KEY (`id_clientes`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_administradores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_administradores` (
  `id_administradores` INT NOT NULL AUTO_INCREMENT,
  `nivel_acesso` INT NOT NULL,
  PRIMARY KEY (`id_administradores`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_funcionarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_funcionarios` (
  `id_funcionarios` INT NOT NULL,
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
  PRIMARY KEY (`id_funcionarios`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_recepcionista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_recepcionista` (
  `id_recepcionista` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_recepcionista`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_compras`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_compras` (
  `id_compras` INT NOT NULL AUTO_INCREMENT,
  `data_compra` DATETIME NOT NULL,
  `valor_total` DECIMAL(10,2) NOT NULL,
  `observacoes` TEXT NOT NULL,
  PRIMARY KEY (`id_compras`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_itens_compra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_itens_compra` (
  `id_itens_compra` INT NOT NULL AUTO_INCREMENT,
  `quantidade` INT NOT NULL,
  `valor_unitario` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id_itens_compra`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_agendamentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_agendamentos` (
  `id_agendamentos` INT NOT NULL AUTO_INCREMENT,
  `data_hora` DATETIME NULL,
  `status` ENUM('agendado', 'realizado', 'cancelado') NULL,
  PRIMARY KEY (`id_agendamentos`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_historico_agendamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_historico_agendamento` (
  `id_historico_agendamento` INT NOT NULL AUTO_INCREMENT,
  `observacoes` TEXT NOT NULL,
  PRIMARY KEY (`id_historico_agendamento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_pagamentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_pagamentos` (
  `id_pagamentos` INT NOT NULL AUTO_INCREMENT,
  `valor` DECIMAL(10,2) NOT NULL,
  `forma_pagamento` ENUM('boleto', 'cartao', 'pix') NOT NULL,
  `data_pagamento` DATETIME NOT NULL,
  PRIMARY KEY (`id_pagamentos`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_rainhadoouro`.`tb_avaliacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_rainhadoouro`.`tb_avaliacoes` (
  `id_avaliacoes` INT NOT NULL,
  `nota` INT NOT NULL,
  `comentario` TEXT NOT NULL,
  `data_avaliacao` DATETIME NOT NULL,
  PRIMARY KEY (`id_avaliacoes`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
