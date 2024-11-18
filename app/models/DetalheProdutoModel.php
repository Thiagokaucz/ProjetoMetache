<?php
require_once 'config/Database.php';

class ProductModel {
    private $conn;

    public function __construct($database) {
        $this->conn = $database->obterConexao();
    }

    public function getProdutoById($id) {
        $query = "
            SELECT p.produtoID, p.titulo, p.condicao, p.descricao, p.valor, p.locImagem, p.dataHoraPub, p.localizacao, p.visualizacao, p.disponibilidade,  
                   u.nome AS nomeAnunciante, u.dataHoraRegistro AS dataEntradaAnunciante, 
                   c.categoria AS nomeCategoria -- Adiciona o nome da categoria
            FROM produto p
            INNER JOIN usuario u ON p.userID = u.userID
            LEFT JOIN categoria c ON p.categoriaID = c.categoriaID
            WHERE p.produtoID = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function incrementarVisualizacao($productId) {
        $query = "UPDATE produto SET visualizacao = visualizacao + 1 WHERE produtoID = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getUserIDByProductId($produtoID) {
        $query = "SELECT userID FROM produto WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['userID'] : null;
    }

    public function contarVendasPorVendedor($userID) {
        $query = "SELECT COUNT(*) AS totalVendas FROM aquisicoes WHERE vendedorID = :userID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['totalVendas'] ?? 0;
    }

    public function contarDenunciasPorVendedor($vendedorID) {
        $query = "
            SELECT COUNT(*) AS totalDenuncias
            FROM denuncias d
            INNER JOIN aquisicoes a ON d.aquisicaoID = a.aquisicaoID
            WHERE a.vendedorID = :vendedorID";
            
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':vendedorID', $vendedorID, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['totalDenuncias'] ?? 0;
    }
}
