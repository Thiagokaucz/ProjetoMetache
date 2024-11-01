<?php
require_once 'config/Database.php';

class PagamentoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->obterConexao();
    }

    public function getPagamentoDetails($id) {
        // Busca os dados na tabela compraspagamento pelo id
        $sql = "SELECT cp.id, cp.payment_id, cp.status, cp.link_compra_id, cp.produto_id, 
                       cp.chat_id, cp.vendedor_id, cp.valor_bruto_compra, cp.valor_compra, 
                       cp.valor_frete, cp.created_at, cp.statusAdmMetache, cp.aquisicaoID
                FROM compraspagamento cp
                WHERE cp.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $pagamento = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($pagamento) {
            // Busca o vendedor na tabela usuario
            $sqlUsuario = "SELECT userID, nome, sobrenome, email, senha, cep, dataHoraRegistro, statusConta 
                           FROM usuario 
                           WHERE userID = :vendedorID";
            
            $stmtUsuario = $this->db->prepare($sqlUsuario);
            $stmtUsuario->bindParam(':vendedorID', $pagamento['vendedor_id']);
            $stmtUsuario->execute();
            $vendedor = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
    
            return [
                'pagamento' => $pagamento,
                'vendedor' => $vendedor
            ];
        }
        return null;
    }

    public function finalizarPagamento($id) {
        // Atualiza o statusAdmMetache para 'finalizado'
        $sql = "UPDATE compraspagamento SET statusAdmMetache = 'finalizado' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
