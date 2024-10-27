<?php
require_once 'config/database.php'; // Inclua o arquivo de configuração do banco de dados

class VerificarCompraModel {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->obterConexao();
    }

    public function inserirCompra($payment_id, $status, $linkCompraID, $produtoID, $chatID, $vendedorID, $valorBrutoCompra, $valorCompra, $valorFrete) {
        $query = "INSERT INTO compraspagamento (payment_id, status, link_compra_id, produto_id, chat_id, vendedor_id, valor_bruto_compra, valor_compra, valor_frete)
                  VALUES (:payment_id, :status, :link_compra_id, :produto_id, :chat_id, :vendedor_id, :valor_bruto_compra, :valor_compra, :valor_frete)";

        $stmt = $this->pdo->prepare($query);
        
        // Bind dos parâmetros
        $stmt->bindParam(':payment_id', $payment_id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':link_compra_id', $linkCompraID);
        $stmt->bindParam(':produto_id', $produtoID);
        $stmt->bindParam(':chat_id', $chatID);
        $stmt->bindParam(':vendedor_id', $vendedorID);
        $stmt->bindParam(':valor_bruto_compra', $valorBrutoCompra);
        $stmt->bindParam(':valor_compra', $valorCompra);
        $stmt->bindParam(':valor_frete', $valorFrete);
        
        // Executa a query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
