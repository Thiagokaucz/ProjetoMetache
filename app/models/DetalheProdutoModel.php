<?php
require_once 'config/Database.php'; // Inclua o caminho correto para o seu arquivo Database.php

class ProductModel {
    private $conn;

    // Construtor que recebe uma instância de Database
    public function __construct($database) {
        $this->conn = $database->obterConexao();
    }

    // Método para buscar os detalhes do produto
    public function getProductDetails($productId) {
        $query = "SELECT p.produtoID, p.titulo, p.condicao, p.descricao, p.valor, p.locImagem, p.dataHoraPub, p.localizacao, u.nome, u.dataCadastro, u.status 
                  FROM produto p
                  INNER JOIN usuarios u ON p.userID = u.userID
                  WHERE p.produtoID = :productId";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para buscar o produto pelo id
    public function getProdutoById($id) {
        // Consulta SQL para buscar produto e informações do anunciante (nome e data de entrada)
        $query = "
            SELECT p.produtoID, p.titulo, p.condicao, p.descricao, p.valor, p.locImagem, p.dataHoraPub, p.localizacao,  
                   u.nome AS nomeAnunciante, u.dataHoraRegistro AS dataEntradaAnunciante
            FROM produto p
            INNER JOIN usuario u ON p.userID = u.userID
            WHERE p.produtoID = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Retorna os dados do produto junto com os dados do anunciante
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para incrementar visualizações
    public function incrementarVisualizacao($productId) {
    $query = "UPDATE produto SET visualizacao = visualizacao + 1 WHERE produtoID = :productId";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
    return $stmt->execute(); // Retorna verdadeiro se a execução for bem-sucedida
}

}
?>
