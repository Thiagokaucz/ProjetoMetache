<?php
require_once 'config/Database.php';

class AdmCancelarCompraModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->obterConexao();
    }

    public function cancelarCompra($aquisicaoID) {
        try {
            $this->db->beginTransaction();

            // Atualiza o status em aquisicao
            $sqlAquisicao = "UPDATE aquisicoes SET statusAquisicao = 'compra_cancelada' WHERE aquisicaoID = :aquisicaoID";
            $stmtAquisicao = $this->db->prepare($sqlAquisicao);
            $stmtAquisicao->bindParam(':aquisicaoID', $aquisicaoID);
            $stmtAquisicao->execute();

            // Atualiza o status em compraspagamento
            $sqlPagamento = "UPDATE compraspagamento SET statusAdmMetache = 'compra_cancelada' WHERE aquisicaoID = :aquisicaoID";
            $stmtPagamento = $this->db->prepare($sqlPagamento);
            $stmtPagamento->bindParam(':aquisicaoID', $aquisicaoID);
            $stmtPagamento->execute();

            // Busca o ID do comprador
            $sqlComprador = "SELECT compradorID FROM aquisicoes WHERE aquisicaoID = :aquisicaoID";
            $stmtComprador = $this->db->prepare($sqlComprador);
            $stmtComprador->bindParam(':aquisicaoID', $aquisicaoID);
            $stmtComprador->execute();
            $compradorID = $stmtComprador->fetchColumn();

            // Busca os dados do comprador na tabela usuario
            $sqlUsuario = "SELECT nome, sobrenome, email, cep FROM usuario WHERE userID = :compradorID";
            $stmtUsuario = $this->db->prepare($sqlUsuario);
            $stmtUsuario->bindParam(':compradorID', $compradorID);
            $stmtUsuario->execute();
            $comprador = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

            $this->db->commit();
            return $comprador; // Retorna os dados do comprador
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
?>
