<?php
require_once 'config/Database.php'; 

class VisualizarDocumentosModel {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->obterConexao();
    }

    public function buscarDocumentosPorProdutoId($produtoId) {

        $queryPagamento = "SELECT id FROM compraspagamento WHERE produto_id = :produto_id";
        $stmtPagamento = $this->pdo->prepare($queryPagamento);
        $stmtPagamento->bindParam(':produto_id', $produtoId);
        $stmtPagamento->execute();
        
        $compraPagamentoId = $stmtPagamento->fetchColumn();
        
        if ($compraPagamentoId) {
            $queryDocumentos = "SELECT notaFiscal, compPagamento FROM documentos WHERE compraspagamentoID = :compraPagamentoId";
            $stmtDocumentos = $this->pdo->prepare($queryDocumentos);
            $stmtDocumentos->bindParam(':compraPagamentoId', $compraPagamentoId);
            $stmtDocumentos->execute();
            return $stmtDocumentos->fetch(PDO::FETCH_ASSOC); 
        }

        return null; 
    }
}
?>
