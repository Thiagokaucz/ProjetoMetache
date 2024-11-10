<?php

require_once 'config/Database.php';

class UsuarioModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    // Atualiza o token e o status de vendedor do usuário com base no user_id
    public function atualizarToken($user_id, $token)
    {
        $sql = "UPDATE usuario SET token = :token, is_vendedor = 'sim' WHERE userID = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }
}
