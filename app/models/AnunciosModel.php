<?php

class HomeModel {
    
    private $db;

    // Construtor para inicializar a conexão com o banco de dados
    public function __construct() {
        // Instancia a classe Database e armazena a conexão no atributo $db
        $dbInstance = new Database();
        $this->db = $dbInstance->getConnection();
    }
    
    // Função para buscar os anúncios recentes com limite
    public function getAnunciosRecentes($limit) {
        $query = $this->db->prepare("SELECT * FROM produto ORDER BY dataHoraPub DESC LIMIT :limit");
        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Função para buscar os anúncios mais pesquisados com limite
    public function getMaisPesquisados($limit) {
        $query = $this->db->prepare("SELECT * FROM produto ORDER BY visualizacao DESC LIMIT :limit");
        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
