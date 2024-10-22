<?php

require_once 'config/Database.php';

class HomeModel {
    
    private $conn;

    // Construtor que aceita uma conexão PDO
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Função para buscar os anúncios recentes com limite, mostrando apenas produtos disponíveis
    public function getAnunciosRecentes($limit) {
        $query = $this->conn->prepare("SELECT * FROM produto WHERE disponibilidade = 'disponível' ORDER BY dataHoraPub DESC LIMIT :limit");
        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Função para buscar os anúncios mais pesquisados com limite, mostrando apenas produtos disponíveis
    public function getMaisPesquisados($limit) {
        $query = $this->conn->prepare("SELECT * FROM produto WHERE disponibilidade = 'disponível' ORDER BY visualizacao DESC LIMIT :limit");
        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função para buscar todas as categorias
    public function getTodasCategorias() {
        $sql = "SELECT * FROM categoria";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
