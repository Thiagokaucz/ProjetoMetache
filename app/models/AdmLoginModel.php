<?php
require_once 'config/Database.php';

class AdmLogin {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function login($usuario, $senha) {
        $query = 'SELECT * FROM administrador WHERE usuario = :usuario';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($senha, $admin['senha'])) {
            return $admin; // Retorna o administrador logado com todas as informações, incluindo o cargo
        }

        return false; // Retorna falso se as credenciais estiverem incorretas
    }
}
