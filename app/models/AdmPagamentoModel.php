<?php
require_once 'config/Database.php';

class AdmPagamentoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->obterConexao();
    }

    public function getPagamentoDetails($id) {
        $sql = "SELECT cp.*, p.titulo AS titulo_produto, p.locImagem AS imagem_produto, 
                       u.nome, u.sobrenome, u.email
                FROM compraspagamento cp
                LEFT JOIN produto p ON cp.produto_id = p.produtoID
                LEFT JOIN usuario u ON cp.vendedor_id = u.userID
                WHERE cp.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $pagamento = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($pagamento) {
            $sqlDenuncia = "SELECT motivo, status, dataCriacao FROM denuncias WHERE aquisicaoID = :aquisicaoID";
            $stmtDenuncia = $this->db->prepare($sqlDenuncia);
            $stmtDenuncia->bindParam(':aquisicaoID', $pagamento['aquisicaoID']);
            $stmtDenuncia->execute();
            $denuncia = $stmtDenuncia->fetch(PDO::FETCH_ASSOC);
            
            return [
                'pagamento' => $pagamento,
                'vendedor' => [
                    'nome' => $pagamento['nome'] ?? 'N/A',
                    'sobrenome' => $pagamento['sobrenome'] ?? 'N/A',
                    'email' => $pagamento['email'] ?? 'N/A',
                ],
                'denuncia' => $denuncia
            ];
        }
        return null;
    }

    public function finalizarPagamento($id) {
        $sql = "UPDATE compraspagamento SET statusAdmMetache = 'finalizado' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function atualizarStatusDenuncia($aquisicaoID, $novoStatus) {
        $sql = "UPDATE denuncias SET status = :status WHERE aquisicaoID = :aquisicaoID";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $novoStatus);
        $stmt->bindParam(':aquisicaoID', $aquisicaoID);
        return $stmt->execute();
    }
}
?>