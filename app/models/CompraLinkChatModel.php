<?php
require_once 'config/Database.php';

class CompraLinkChatModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function getDadosCompra($linkCompraId, $produtoID) {
        $stmt = $this->conn->prepare("
            SELECT lc.linkCompraID, lc.valorBrutoCompra, lc.valorCompra, lc.statusLinkCompra, lc.valorFrete, 
                   p.produtoID, p.titulo, p.descricao, p.valor 
            FROM linkcompra lc 
            JOIN produto p ON lc.produtoID = p.produtoID 
            WHERE lc.linkCompraID = :linkCompraId
        ");
        $stmt->bindParam(':linkCompraId', $linkCompraId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
