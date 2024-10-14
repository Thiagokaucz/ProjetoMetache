<?php
require_once 'config/Database.php';

class ChatListaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function obterChatsCompras($valorID) {
        $query = 'SELECT * FROM chat WHERE compradorID = :valorID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':valorID', $valorID); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function obterChatsVendas($valorID) {
        $query = 'SELECT * FROM chat WHERE vendedorID = :valorID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':valorID', $valorID); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }



    // Método para verificar se o usuário está na coluna userID
    public function userExistsInUserID($compradorID) {
        $query = 'SELECT COUNT(*) FROM chat WHERE compradorID = :compradorID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':compradorID', $compradorID);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Método para verificar se o usuário está na coluna compradorID
    public function userExistsInCompradorID($compradorID) {
        $query = 'SELECT COUNT(*) FROM chat WHERE vendedorID = :compradorID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':compradorID', $compradorID);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}