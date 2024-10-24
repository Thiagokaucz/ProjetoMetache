<?php
require_once 'config/Database.php';

class EditarProdutoModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    // Buscar o produto pelo produtoID
    public function buscarProdutoPorID($produtoID) {
        $sql = "SELECT produtoID, userID, categoriaID, titulo, condicao, descricao, valor, localizacao 
                FROM produto 
                WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar os campos do produto
    public function atualizarProduto($produtoID, $categoriaID, $titulo, $condicao, $descricao, $valor, $localizacao) {
        $sql = "UPDATE produto 
                SET categoriaID = :categoriaID, titulo = :titulo, condicao = :condicao, descricao = :descricao, valor = :valor, localizacao = :localizacao
                WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':categoriaID', $categoriaID, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':condicao', $condicao, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':localizacao', $localizacao, PDO::PARAM_STR);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
