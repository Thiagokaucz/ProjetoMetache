<?php
require_once 'config/Database.php'; // Inclua o caminho correto para o seu arquivo Database.php

class NotificacaoModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    // Função para obter todas as notificações de um usuário
    public function getNotificacoesByUserID($destinatarioID) {
        $query = '
            SELECT n.*, c.produtoID, p.locImagem, p.titulo AS produtoTitulo, u.nome AS usuarioNome
            FROM notificacao AS n
            LEFT JOIN chat AS c ON n.chatID = c.chatID
            LEFT JOIN produto AS p ON c.produtoID = p.produtoID
            LEFT JOIN usuario AS u ON c.compradorID = u.userID
            WHERE n.destinatarioID = :destinatarioID
            ORDER BY n.dataHora DESC
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':destinatarioID', $destinatarioID);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    

    // Função para excluir uma notificação
    public function deleteNotificacao($notificacaoID) {
        $query = 'DELETE FROM notificacao WHERE notificacaoID = :notificacaoID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':notificacaoID', $notificacaoID);
        return $stmt->execute(); // Retorna true se a exclusão for bem-sucedida
    }

    // Função para obter o produtoID usando o chatID
    public function getProdutoIDByChatID($chatID) {
        $query = 'SELECT produtoID FROM chat WHERE chatID = :chatID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['produtoID'] : null;
    }
}
