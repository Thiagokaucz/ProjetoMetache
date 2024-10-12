<?php

require_once 'config/Database.php';

class HomeModel {
    
    private $conn;

    // Construtor que aceita uma conexão PDO
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Função para buscar os anúncios recentes com limite
    public function getAnunciosRecentes($limit) {
        $query = $this->conn->prepare("SELECT * FROM produto ORDER BY dataHoraPub DESC LIMIT :limit");
        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Função para buscar os anúncios mais pesquisados com limite
    public function getMaisPesquisados($limit) {
        $query = $this->conn->prepare("SELECT * FROM produto ORDER BY visualizacao DESC LIMIT :limit");
        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
