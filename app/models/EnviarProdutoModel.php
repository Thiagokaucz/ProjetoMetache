<?php
require_once 'config/Database.php';

class EnviarProdutoModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function gravarEnvioProduto($aquisicaoID, $transportadora, $codigoRastreio, $comentario, $dataHora) {
        $sql = "INSERT INTO envioProduto (aquisicaoID, transportadora, dataHora, codigoRastreio, comentario) 
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
        $sql = "UPDATE aquisicoes SET statusAquisicao = 'finalizado' WHERE aquisicaoID = :aquisicaoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':aquisicaoID', $aquisicaoID, PDO::PARAM_INT);
        $stmt->execute();
    }
}
