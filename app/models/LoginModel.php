<?php
require_once 'config/Database.php'; // Inclua o caminho correto para o seu arquivo Database.php

class LoginModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function login($email, $senha) {
        $query = 'SELECT * FROM usuario WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            if ($user['statusConta'] === 'desativada') {
                // Retorna uma mensagem informando que a conta foi desativada
                return 'desativada';
            } elseif (password_verify($senha, $user['senha'])) {
                // Se a senha estiver correta e a conta ativa, retorna os dados do usuário
                return $user;
            }
        }
    
        return false; // Se falhar, retorna falso
    }
    

}
