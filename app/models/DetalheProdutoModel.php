<?php
require_once 'config/Database.php'; // Inclua o caminho correto para o seu arquivo Database.php

class ProductModel {
    private $db;

    // Construtor que recebe uma instância de Database
    public function __construct($database) {
        $this->db = $database->getConnection();
    }

    // Método para buscar os detalhes do produto
    public function getProductDetails($productId) {
        $query = "SELECT p.produtoID, p.titulo, p.condicao, p.descricao, p.valor, p.locImagem, p.dataHoraPub, p.localizacao, u.nome, u.dataCadastro, u.status
                  FROM produto p
                  INNER JOIN usuarios u ON p.userID = u.userID
                  WHERE p.produtoID = :productId";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class Produto {
    private $db;

    // Construtor que recebe uma instância de Database
    public function __construct($database) {
        $this->db = $database->getConnection();
    }

    // Método para buscar o produto pelo id
    public function getProdutoById($id) {
        $stmt = $this->db->prepare("SELECT * FROM produto WHERE produtoID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Retorna os dados do produto
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
