<?php
require_once 'config/Database.php';

class CadastroModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function emailExists($email) {
        $query = 'SELECT COUNT(*) FROM usuario WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }

    public function cadastrar($nome, $sobrenome, $email, $senha, $cep) {
        $query = 'INSERT INTO usuario (nome, sobrenome, email, senha, cep, dataHoraRegistro, statusConta) 
                  VALUES (:nome, :sobrenome, :email, :senha, :cep, NOW(), "ativa")';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':cep', $cep);
        $stmt->execute();

        return $this->conn->lastInsertId(); 
    }
}
