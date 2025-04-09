create database RainhadoOuro;
use RainhadoOuro;
 
-- Tabela de Usuários
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255),
    tipo_usuario ENUM('adm', 'recepcionista', 'cliente', 'cabeleleiro'),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    ativo BOOLEAN DEFAULT TRUE
);

-- Tabela de Clientes
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    nome VARCHAR(50),
    telefone VARCHAR(20),
    data_nascimento DATE,
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(10),
    cep VARCHAR(12),
    rua VARCHAR(30),
    numero INT,
    bairro VARCHAR(20),
    cidade VARCHAR(30),
    estado CHAR(2),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabela de Recepcionistas
CREATE TABLE recepcionistas (
    id_recepcionista INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabela de Cabeleleiros
CREATE TABLE cabeleleiros (
    id_cabeleleiro INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    especialidade VARCHAR(100),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabela de Administradores
CREATE TABLE administradores (
    id_adm INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabela de Funcionários
CREATE TABLE funcionarios (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,       
    nome_completo VARCHAR(100) NOT NULL,
    data_nascimento DATE NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    rg VARCHAR(20),
    sexo ENUM('Feminino', 'Masculino', 'Outro', 'Prefiro não informar'),
    estado_civil ENUM('Solteiro(a)', 'Casado(a)', 'Divorciado(a)', 'Viúvo(a)'),
    telefone VARCHAR(20),
    email VARCHAR(100),
    cep VARCHAR(9),
    rua VARCHAR(100),
    numero VARCHAR(10),
    bairro VARCHAR(50),
    cidade VARCHAR(50),
    estado VARCHAR(2),
    cargo VARCHAR(50) NOT NULL,
    data_admissao DATE NOT NULL,
    horario_trabalho VARCHAR(50),
    salario DECIMAL(10,2),
    tipo_contrato ENUM('CLT', 'Autônomo', 'Freelancer'),
    carteira_trabalho VARCHAR(20),
    pis VARCHAR(20),
    status ENUM('Ativo', 'Inativo') DEFAULT 'Ativo',
    observacoes TEXT,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) 
);

-- Tabela de Fornecedores
CREATE TABLE fornecedores (
    id_fornecedor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cnpj VARCHAR(20),
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco TEXT
);

-- Tabela de Produtos
CREATE TABLE produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    descricao TEXT,
    preco_venda DECIMAL(10,2),
    categoria VARCHAR(50),
    fornecedor VARCHAR(100),
    estoque INT,
    ativo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (fornecedor) REFERENCES fornecedores(nome),
    FOREIGN KEY (estoque) REFERENCES estoque(quantidade),
);

-- Tabela de Serviços
CREATE TABLE servicos (
    id_servico INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    descricao TEXT,
    preco DECIMAL(10,2),
    duracao_min INT,
    ativo BOOLEAN DEFAULT TRUE
);

-- Tabela de Estoque
CREATE TABLE estoque (
    id_estoque INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT,
    quantidade INT,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);

-- Tabela de Compras
CREATE TABLE compras (
    id_compra INT AUTO_INCREMENT PRIMARY KEY,
    id_fornecedor INT,
    data_compra DATETIME,
    valor_total DECIMAL(10,2),
    observacoes TEXT,
    FOREIGN KEY (id_fornecedor) REFERENCES fornecedores(id_fornecedor)
);

-- Itens da Compra
CREATE TABLE itens_compra (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT,
    id_produto INT,
    quantidade INT,
    valor_unitario DECIMAL(10,2),
    FOREIGN KEY (id_compra) REFERENCES compras(id_compra),
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);

-- Agendamentos
CREATE TABLE agendamentos (
    id_agendamento INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    id_servico INT,
    id_funcionario INT,
    data_hora DATETIME,
    status ENUM('agendado', 'realizado', 'cancelado'),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_servico) REFERENCES servicos(id_servico),
    FOREIGN KEY (id_funcionario) REFERENCES funcionarios(id_funcionario)
);

-- Histórico de Atendimentos
CREATE TABLE historico_atendimentos (
    id_historico INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    id_agendamento INT,
    observacoes TEXT,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_agendamento) REFERENCES agendamentos(id_agendamento)
);

-- Pagamentos
CREATE TABLE pagamentos (
    id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    valor DECIMAL(10,2),
    forma_pagamento ENUM('dinheiro', 'cartao', 'pix'),
    data_pagamento DATETIME,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

-- Vendas
CREATE TABLE vendas (
    id_venda INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    data_venda DATETIME,
    total_venda DECIMAL(10,2),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

-- Itens da Venda
CREATE TABLE itens_venda (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_venda INT,
    id_produto INT,
    quantidade INT,
    valor_unitario DECIMAL(10,2),
    FOREIGN KEY (id_venda) REFERENCES vendas(id_venda),
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);

-- Avaliações
CREATE TABLE avaliacoes (
    id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    id_servico INT,
    nota INT CHECK (nota BETWEEN 1 AND 5),
    comentario TEXT,
    data_avaliacao DATETIME,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_servico) REFERENCES servicos(id_servico)
);

-- Carrinho
CREATE TABLE carrinho (
    id_carrinho INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    data_criacao DATETIME,
    status ENUM('aberto', 'fechado'),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

-- Itens do Carrinho
CREATE TABLE itens_carrinho (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_carrinho INT,
    id_produto INT,
    quantidade INT,
    FOREIGN KEY (id_carrinho) REFERENCES carrinho(id_carrinho),
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);
