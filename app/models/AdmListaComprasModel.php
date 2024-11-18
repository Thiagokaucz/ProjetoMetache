<?php
require_once 'config/Database.php';

class ComprasPagamentoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->obterConexao();
    }

    public function obterComprasPendentes() {
        $sql = "
            SELECT cp.*, p.titulo, p.locImagem 
            FROM compraspagamento cp
            JOIN produto p ON cp.produto_id = p.produtoID
            WHERE cp.statusAdmMetache = 'pendente_pagamento'";
            
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
