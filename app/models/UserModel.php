<?php
require_once 'config/Database.php'; // Inclua o caminho correto para o seu arquivo Database.php

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Função para verificar se o email já existe
    public function emailExists($email) {
        $query = 'SELECT COUNT(*) FROM Usuario WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0; // Retorna true se o e-mail já existir
    }

    // Função para login
    public function login($email, $senha) {
        $query = 'SELECT * FROM Usuario WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            return $user; // Retorna o usuário logado
        }

        return false; // Se falhar, retorna falso
    }

    // Função para cadastrar usuário
    public function cadastrar($nome, $sobrenome, $email, $senha, $cep) {
        $query = 'INSERT INTO Usuario (nome, sobrenome, email, senha, cep, dataHoraRegistro) 
                  VALUES (:nome, :sobrenome, :email, :senha, :cep, NOW())';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':cep', $cep);

        return $stmt->execute(); // Retorna true se for bem-sucedido
    }
}
