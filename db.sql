-- Criacao das tabelas
CREATE TABLE Usuario (
    userID INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    numeroTelefone VARCHAR(20),
    tipoUsuario ENUM('admin', 'user') NOT NULL,
    dataRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
