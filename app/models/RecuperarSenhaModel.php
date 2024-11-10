<?php
require_once 'config/Database.php';

class RecuperarSenhaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function buscarUsuarioPorEmail($email) {
        $query = "SELECT email, pergunta1, pergunta2, resposta1, resposta2 FROM usuario WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarSenha($email, $novaSenha) {
        $query = "UPDATE usuario SET senha = :senha WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':senha', $novaSenha);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
}
