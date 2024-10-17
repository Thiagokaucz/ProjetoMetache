<?php
require_once 'config/Database.php';

class PerfilUsuarioModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    // Buscar usuário por ID (usuário em sessão)
    public function buscarUsuarioPorID($userID) {
        $sql = "SELECT * FROM usuario WHERE userID = :userID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar dados do usuário
    public function atualizarUsuario($userID, $nome, $sobrenome, $email, $cep) {
        $sql = "UPDATE usuario SET nome = :nome, sobrenome = :sobrenome, email = :email, cep = :cep WHERE userID = :userID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Desativa o usuário logado
    public function desativarUsuario($userID) {
        $sql = "UPDATE usuario SET statusConta = 'desativada' WHERE userID = :userID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
}
?>
