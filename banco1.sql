CREATE SCHEMA IF NOT EXISTS `db_rainhadoouro`;
USE `db_rainhadoouro`;

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
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_produtos`)
) ENGINE = InnoDB;

-- Serviços
CREATE TABLE IF NOT EXISTS `tb_servicos` (
  `id_servicos` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  `duracao_min` INT NOT NULL,
  `preco` DECIMAL(10,2) NOT NULL,
  `path` VARCHAR(100) NOT NULL,
  `data_upload` DATE NOT NULL,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_servicos`)
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
  `tipo_funcionario` VARCHAR(50) NOT NULL,
  `horario_trabalho` TIME NOT NULL,
  `salario` DECIMAL(10,2) NOT NULL,
  `tipo_contrato` ENUM('CLT', 'Autônomo', 'Freelancer') NOT NULL,
  `carteira_trabalho` VARCHAR(20) NOT NULL,
  `pis` VARCHAR(20) NOT NULL,
  `status` ENUM('Ativo', 'Inativo') NOT NULL DEFAULT 'Ativo',
  `observacoes` TEXT NOT NULL,
  `data_cadastro` DATE NOT NULL DEFAULT (CURRENT_DATE),
  PRIMARY KEY (`id_funcionarios`),
  UNIQUE KEY `unique_cpf` (`cpf`)
) ENGINE = InnoDB;

-- Clientes
CREATE TABLE IF NOT EXISTS `tb_clientes` (
  `id_clientes` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60) NOT NULL,
  `telefone` VARCHAR(20) NOT NULL,
  `cpf` VARCHAR(14) NOT NULL,
  `data_nascimento` DATE NOT NULL,
  `genero` VARCHAR(45) NOT NULL,
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

CREATE TABLE IF NOT EXISTS tb_itens_carrinho (
  id_item INT AUTO_INCREMENT PRIMARY KEY,
  id_carrinho INT NOT NULL,
  id_produto INT NOT NULL,
  quantidade INT NOT NULL,
  preco_unit DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (id_carrinho) REFERENCES tb_carrinho(id_carrinho) ON DELETE CASCADE,
  FOREIGN KEY (id_produto) REFERENCES tb_produtos(id_produtos)
) ENGINE = InnoDB;

-- Compras
CREATE TABLE IF NOT EXISTS `tb_compras` (
  `id_compras` INT NOT NULL AUTO_INCREMENT,
  `data_compra` DATETIME NOT NULL,
  `valor_total` DECIMAL(10,2) NOT NULL,
  `observacoes` TEXT NOT NULL,
  PRIMARY KEY (`id_compras`)
) ENGINE = InnoDB;

-- Agendamentos
CREATE TABLE IF NOT EXISTS `tb_agendamentos` (
  `id_agendamentos` INT NOT NULL AUTO_INCREMENT,
  `servico` VARCHAR(60) NOT NULL,
  `tipoServico` VARCHAR(95) NOT NULL,
  `data` DATE NOT NULL,
  `horario` TIME NOT NULL,
  `status` ENUM('agendado', 'realizado', 'cancelado') DEFAULT 'agendado',
  `tb_clientes_id_clientes` INT NOT NULL,
  `nome` VARCHAR(255),
  `sobrenome` VARCHAR(255),
  `email` VARCHAR(255),
  `telefone` VARCHAR(20),
  PRIMARY KEY (`id_agendamentos`),
  FOREIGN KEY (`tb_clientes_id_clientes`) REFERENCES `tb_clientes` (`id_clientes`)
) ENGINE = InnoDB;


-- Tabela de vendas
CREATE TABLE IF NOT EXISTS `tb_vendas` (
  `id_venda` INT AUTO_INCREMENT PRIMARY KEY,
  `data_venda` DATE NOT NULL,               
  `valor` DECIMAL(10,2) NOT NULL             
) ENGINE = InnoDB;

-- Gerenciamento de login
CREATE TABLE `tb_login_gerencia` (
  id_login INT AUTO_INCREMENT PRIMARY KEY,
  id_funcionario INT NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  tipo_usuario ENUM('adm', 'recepcionista', 'cabeleireiro', 'atendente') NOT NULL,
  ativo TINYINT(1) DEFAULT 1,
  FOREIGN KEY (id_funcionario) REFERENCES tb_funcionarios(id_funcionarios)
) ENGINE=InnoDB;

-- Pedidos
CREATE TABLE tb_pedidos (
  id_pedidos INT AUTO_INCREMENT PRIMARY KEY,
  id_cliente INT NOT NULL,
  cep VARCHAR(20) NULL,
  data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
  total DECIMAL(10,2) NOT NULL,
  status VARCHAR(50) DEFAULT 'Pendente',
  FOREIGN KEY (id_cliente) REFERENCES tb_clientes(id_clientes)
) ENGINE = InnoDB;

CREATE TABLE tb_itens_pedido (
  id_item INT AUTO_INCREMENT PRIMARY KEY,
  id_pedidos INT NOT NULL,
  id_produtos INT NOT NULL,
  quantidade INT NOT NULL,
  preco_unit DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (id_pedidos) REFERENCES tb_pedidos(id_pedidos),
  FOREIGN KEY (id_produtos) REFERENCES tb_produtos(id_produtos)
) ENGINE = InnoDB;

-- Gatilho de venda automática
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
