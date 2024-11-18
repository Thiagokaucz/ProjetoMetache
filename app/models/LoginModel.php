<?php
require_once 'config/Database.php'; 

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
                return 'desativada';
            } elseif (password_verify($senha, $user['senha'])) {
                return $user;
            }
        }
    
        return false; 
    }
    

}
