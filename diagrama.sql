CREATE DATABASE IF NOT EXISTS gestao_estoque CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE gestao_estoque;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    descricao TEXT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    quantidade INT NOT NULL DEFAULT 0,
    data_validade DATE NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
