<?php
require_once 'config/Database.php';

class ComprasFinalizadasCanceladasModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->obterConexao();
    }

    public function obterComprasFinalizadasCanceladas() {
        $sql = "
            SELECT cp.*, p.titulo, p.locImagem 
            FROM compraspagamento cp
            JOIN produto p ON cp.produto_id = p.produtoID
            WHERE cp.statusAdmMetache IN ('finalizado', 'compra_cancelada')";
            
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
