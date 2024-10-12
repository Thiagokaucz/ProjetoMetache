<?php
require_once 'config/Database.php';

class ChatMensagemModel {
    private $pdo;

    public function __construct() {
        $database = new Database(); // Cria uma nova instância da classe Database
        $this->pdo = $database->getConnection(); // Obtém a conexão
    }

    public function getMessagesByChatId($chatId) {
        $stmt = $this->pdo->prepare("SELECT * FROM mensagem WHERE chatID = :chatId ORDER BY dataHora ASC");
        $stmt->bindParam(':chatId', $chatId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
