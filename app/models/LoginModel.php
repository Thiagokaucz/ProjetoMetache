<?php
require_once 'config/Database.php'; // Inclua o caminho correto para o seu arquivo Database.php

class LoginModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

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

}
