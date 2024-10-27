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
                   lc.chatID,  -- Inclui o chatID da tabela linkcompra
                   p.produtoID, p.titulo, p.descricao, p.valor 
            FROM linkcompra lc 
            JOIN produto p ON lc.produtoID = p.produtoID 
            WHERE lc.linkCompraID = :linkCompraId
        ");
        $stmt->bindParam(':linkCompraId', $linkCompraId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVendedorIDPorChatID($chatID) {
        $stmt = $this->conn->prepare("SELECT vendedorID FROM chat WHERE chatID = :chatID");
        $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn(); // Retorna apenas o vendedorID
    }
    
    
}
