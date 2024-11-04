<?php
require_once 'config/Database.php';

class PagamentoVendedorModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->obterConexao();
    }

    public function buscarCompraPorId($id) {
        $sql = "SELECT * FROM compraspagamento WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarStatusPagamento($id, $status) {
        $sql = "UPDATE compraspagamento SET statusPagamentoVendedor = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function calcularValorPagamento($valorCompra) {
        return $valorCompra * 0.05; // Calcula 5% do valor da compra
    }

    public function obterTokenVendedor($vendedor_id) {
        $sql = "SELECT token FROM usuario WHERE userID = :vendedor_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':vendedor_id', $vendedor_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['token'] : null;  // Retorna o token ou null se não encontrado
    }
}
?>
