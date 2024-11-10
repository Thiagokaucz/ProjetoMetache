<?php
require_once 'config/Database.php';

class AdmCadastrarUsuarioModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function usuarioExiste($usuario) {
        $query = 'SELECT * FROM administrador WHERE usuario = :usuario';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function cadastrarUsuario($nome, $usuario, $senha) {
        // Hash da senha antes de armazená-la no banco
        $hashedSenha = password_hash($senha, PASSWORD_DEFAULT);

        $query = 'INSERT INTO administrador (nome, usuario, senha) VALUES (:nome, :usuario, :senha)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':senha', $hashedSenha);
        return $stmt->execute(); // Retorna true em caso de sucesso
    }
}
