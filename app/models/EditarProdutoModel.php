<?php
require_once 'config/Database.php';

class EditarProdutoModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function buscarProdutoPorID($produtoID) {
        $sql = "SELECT produtoID, userID, categoriaID, titulo, condicao, descricao, valor, localizacao 
                FROM produto 
                WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarProduto($produtoID, $titulo, $descricao, $valor) {
        $sql = "UPDATE produto 
                SET titulo = :titulo, descricao = :descricao, valor = :valor
                WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
    }

}
?>
