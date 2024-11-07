<?php

require_once 'config/Database.php';

class DocumentoModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->obterConexao();
    }

    // Método para salvar os caminhos dos documentos na tabela `documentos`
    public function salvarDocumentos($compraspagamentoID, $caminhoNotaFiscal, $caminhoCompPagamento) {
        $sql = "INSERT INTO documentos (compraspagamentoID, notaFiscal, compPagamento)
                VALUES (:compraspagamentoID, :notaFiscal, :compPagamento)
                ON DUPLICATE KEY UPDATE notaFiscal = :notaFiscal, compPagamento = :compPagamento";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':compraspagamentoID', $compraspagamentoID, PDO::PARAM_INT);
        $stmt->bindParam(':notaFiscal', $caminhoNotaFiscal);
        $stmt->bindParam(':compPagamento', $caminhoCompPagamento);
        
        return $stmt->execute();
    }
}
