<?php
require_once 'config/Database.php'; // Inclua o arquivo de configuração do banco de dados

class VisualizarDocumentosModel {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->obterConexao();
    }

    public function buscarDocumentosPorProdutoId($produtoId) {
        // Primeiro, buscamos o ID de compraspagamento com base no produto_id
        $queryPagamento = "SELECT id FROM compraspagamento WHERE produto_id = :produto_id";
        $stmtPagamento = $this->pdo->prepare($queryPagamento);
        $stmtPagamento->bindParam(':produto_id', $produtoId);
        $stmtPagamento->execute();
        
        $compraPagamentoId = $stmtPagamento->fetchColumn();
        
        // Se o ID de compraspagamento foi encontrado, buscamos os documentos
        if ($compraPagamentoId) {
            $queryDocumentos = "SELECT notaFiscal, compPagamento FROM documentos WHERE compraspagamentoID = :compraPagamentoId";
            $stmtDocumentos = $this->pdo->prepare($queryDocumentos);
            $stmtDocumentos->bindParam(':compraPagamentoId', $compraPagamentoId);
            $stmtDocumentos->execute();
            return $stmtDocumentos->fetch(PDO::FETCH_ASSOC); // Retorna os caminhos dos documentos
        }

        return null; // Retorna null se não encontrar o registro
    }
}
?>
