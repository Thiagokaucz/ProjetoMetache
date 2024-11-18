<?php
require_once 'config/Database.php';

class AquisicoesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function buscarAquisicoesPorUsuario($compradorID) {
$sql = "SELECT aquisicaoID, produtoID, chatID, compradorID, dataHora, vendedorID, statusAquisicao, valorproduto AS valorProduto, valorFrete
        FROM aquisicoes 
        WHERE compradorID = :compradorID";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':compradorID', $compradorID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarProdutoPorID($produtoID) {
        $sql = "SELECT produtoID, userID, categoriaID, titulo, condicao, descricao, disponibilidade, valor, locImagem, dataHoraPub, localizacao, visualizacao 
                FROM produto 
                WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function buscarEnvioPorAquisicaoID($aquisicaoID) {
        $sql = "SELECT transportadora, dataHora AS dataHoraEnvio, codigoRastreio, comentario 
                FROM envioproduto 
                WHERE aquisicaoID = :aquisicaoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':aquisicaoID', $aquisicaoID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarStatusAquisicao($aquisicaoID, $novoStatus) {
        $sql = "UPDATE aquisicoes SET statusAquisicao = :novoStatus WHERE aquisicaoID = :aquisicaoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':novoStatus', $novoStatus);
        $stmt->bindParam(':aquisicaoID', $aquisicaoID, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    public function buscarImagemProdutoPorAquisicao($aquisicaoID) {
        $sql = "SELECT p.locImagem 
                FROM aquisicoes a
                JOIN produto p ON a.produtoID = p.produtoID
                WHERE a.aquisicaoID = :aquisicaoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':aquisicaoID', $aquisicaoID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn(); 
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

        public function verificarProdutoEmAquisicao($produtoID) {
            $sql = "SELECT statusAquisicao, statusPagamentoVendedor
                    FROM aquisicoes 
                    WHERE produtoID = :produtoID 
                    LIMIT 1";  
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }
    
}
