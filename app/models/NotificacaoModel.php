<?php
require_once 'config/Database.php'; // Inclua o caminho correto para o seu arquivo Database.php

class NotificacaoModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Função para obter todas as notificações de um usuário
    public function getNotificacoesByUserID($userID) {
        $query = 'SELECT * FROM notificacao WHERE userID = :userID ORDER BY dataHora DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todas as notificações
    }

    // Função para excluir uma notificação
    public function deleteNotificacao($notificacaoID) {
        $query = 'DELETE FROM notificacao WHERE notificacaoID = :notificacaoID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':notificacaoID', $notificacaoID);
        return $stmt->execute(); // Retorna true se a exclusão for bem-sucedida
    }
}
?>
