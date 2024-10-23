<?php
require_once 'config/Database.php';

class ChatListaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function obterChatsCompras($compradorID) {
        $query = '
            SELECT c.*, u.nome AS vendedorNome, p.titulo AS produtoTitulo, p.locImagem
            FROM chat c
            JOIN usuario u ON u.userID = c.vendedorID
            JOIN produto p ON p.produtoID = c.produtoID
            WHERE c.compradorID = :compradorID';
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':compradorID', $compradorID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obterChatsVendas($vendedorID) {
        $query = '
            SELECT c.*, u.nome AS compradorNome, p.titulo AS produtoTitulo, p.locImagem
            FROM chat c
            JOIN usuario u ON u.userID = c.compradorID
            JOIN produto p ON p.produtoID = c.produtoID
            WHERE c.vendedorID = :vendedorID';
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':vendedorID', $vendedorID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirChatPorID($chatID) {
        $query = 'DELETE FROM chat WHERE chatID = :chatID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chatID', $chatID);
        $stmt->execute();
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