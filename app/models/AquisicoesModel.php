<?php
require_once 'config/Database.php';

class AquisicoesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    // Buscar aquisições de um usuário específico
    public function buscarAquisicoesPorUsuario($compradorID) {
        $sql = "SELECT aquisicaoID, produtoID, chatID, compradorID, dataHora, vendedorID, statusAquisicao, valorProduto, valorFrete
                FROM aquisicoes 
                WHERE compradorID = :compradorID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':compradorID', $compradorID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar dados do produto pelo produtoID
    public function buscarProdutoPorID($produtoID) {
        $sql = "SELECT produtoID, userID, categoriaID, titulo, condicao, descricao, disponibilidade, valor, locImagem, dataHoraPub, localizacao, visualizacao 
                FROM produto 
                WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // AquisicoesModel.php

    public function buscarEnvioPorAquisicaoID($aquisicaoID) {
        $sql = "SELECT transportadora, dataHora AS dataHoraEnvio, codigoRastreio, comentario 
                FROM envioProduto 
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
        return $stmt->fetchColumn(); // Retorna apenas a coluna locImagem
    }


    public function atualizarStatusAdmMetache($aquisicaoID) {
        // Primeiro, busca o produtoID usando o aquisicaoID
        $sql = "SELECT produtoID FROM aquisicoes WHERE aquisicaoID = :aquisicaoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':aquisicaoID', $aquisicaoID);
        $stmt->execute();
        
        // Busca o resultado
        $aquisicao = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verifica se o produtoID foi encontrado
        if ($aquisicao) {
            $produtoID = $aquisicao['produtoID'];
    
            // Atualiza o statusAdmMetache para 'pendente_pagamento'
            $updateSql = "UPDATE compraspagamento SET statusAdmMetache = 'pendente_pagamento' WHERE produto_id = :produtoID";
    
            // Prepara a declaração para a atualização
            $updateStmt = $this->conn->prepare($updateSql);
            $updateStmt->bindParam(':produtoID', $produtoID);
    
            // Executa a atualização
            return $updateStmt->execute();
        }
        
        // Retorna false se não encontrou o produtoID
        return false;
    }

        // Verificar se o produto está em aquisição
        public function verificarProdutoEmAquisicao($produtoID) {
            $sql = "SELECT statusAquisicao, statusPagamentoVendedor
                    FROM aquisicoes 
                    WHERE produtoID = :produtoID 
                    LIMIT 1";  // Limite para garantir apenas um resultado
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna o status da aquisição e pagamento
        }
    
}
