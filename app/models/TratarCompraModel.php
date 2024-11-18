<?php
require_once 'config/Database.php';

class TratarCompraModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function enviarMensagemParaVendedor($conteudo, $userID, $chatID) {
        $query = "INSERT INTO mensagem (conteudo, dataHora, userID, chatID) VALUES (:conteudo, NOW(), :userID, :chatID)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':conteudo', $conteudo);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':chatID', $chatID);
        
        return $stmt->execute();
    }
}
