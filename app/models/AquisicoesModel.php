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

}
