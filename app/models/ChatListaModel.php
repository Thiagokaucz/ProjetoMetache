<?php
require_once 'config/Database.php';

class ChatListaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Método para verificar se o usuário está na coluna userID
    public function userExistsInUserID($userID) {
        $query = 'SELECT COUNT(*) FROM chat WHERE userID = :userID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Método para verificar se o usuário está na coluna compradorID
    public function userExistsInCompradorID($userID) {
        $query = 'SELECT COUNT(*) FROM chat WHERE destinatarioID = :userID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Método para obter chats de vendedor
    public function getChatsByUserID($userID) {
        $query = 'SELECT * FROM chat WHERE userID = :userID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os chats do vendedor
    }

    // Método para obter chats de comprador
    public function getChatsByCompradorID($userID) {
        $query = 'SELECT * FROM chat WHERE destinatarioID = :userID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os chats do comprador
    }
}