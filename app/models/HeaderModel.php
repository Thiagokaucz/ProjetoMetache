<?php

require_once 'config/Database.php';

class HeaderModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao(); 
    }

    public function contarNaoVisualizadas($userID) {
        $query = 'SELECT COUNT(*) as total FROM notificacao WHERE destinatarioID = :userID AND visualizacao = "nao_visualizado"';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function marcarTodasComoVisualizadas($userID) {
        $query = 'UPDATE notificacao SET visualizacao = "visualizado" WHERE destinatarioID = :userID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
