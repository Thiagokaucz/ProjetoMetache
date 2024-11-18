<?php
require_once 'config/Database.php';

class EnviarProdutoModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function gravarEnvioProduto($aquisicaoID, $transportadora, $codigoRastreio, $comentario, $dataHora) {
        $sql = "INSERT INTO envioproduto (aquisicaoID, transportadora, dataHora, codigoRastreio, comentario) 
                VALUES (:aquisicaoID, :transportadora, :dataHora, :codigoRastreio, :comentario)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':aquisicaoID', $aquisicaoID, PDO::PARAM_INT);
        $stmt->bindParam(':transportadora', $transportadora, PDO::PARAM_STR);
        $stmt->bindParam(':dataHora', $dataHora, PDO::PARAM_STR); // Bind da nova dataHora
        $stmt->bindParam(':codigoRastreio', $codigoRastreio, PDO::PARAM_STR);
        $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
        $stmt->execute();
    }
    

    public function atualizarStatusAquisicao($aquisicaoID) {
        $sql = "UPDATE aquisicoes SET statusAquisicao = 'enviado' WHERE aquisicaoID = :aquisicaoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':aquisicaoID', $aquisicaoID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function atualizarStatusAdmMetache($aquisicaoID) {

        $sql = "SELECT produtoID FROM aquisicoes WHERE aquisicaoID = :aquisicaoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':aquisicaoID', $aquisicaoID);
        $stmt->execute();
        
        $aquisicao = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($aquisicao) {
            $produtoID = $aquisicao['produtoID'];
    
            $updateSql = "UPDATE compraspagamento SET statusAdmMetache = 'pendente_pagamento' WHERE produto_id = :produtoID";
    
            $updateStmt = $this->conn->prepare($updateSql);
            $updateStmt->bindParam(':produtoID', $produtoID);
    
            return $updateStmt->execute();
        }
        
        return false;
    }
    
}
