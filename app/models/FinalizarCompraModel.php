<?php
require_once 'config/Database.php';

class FinalizarCompraModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->obterConexao(); 
    }
    public function finalizarCompra($produtoID, $chatID, $compradorID, $vendedorID, $valorProduto, $valorFrete) {
        $this->db->beginTransaction();

        try {
            $dataHora = date('Y-m-d H:i:s');

            $sql = "INSERT INTO aquisicoes (produtoID, chatID, compradorID, dataHora, vendedorID, valorProduto, valorFrete, statusAquisicao) 
                    VALUES (:produtoID, :chatID, :compradorID, :dataHora, :vendedorID, :valorProduto, :valorFrete, 'esperando envio')";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':produtoID', $produtoID);
            $stmt->bindParam(':chatID', $chatID);
            $stmt->bindParam(':compradorID', $compradorID);
            $stmt->bindParam(':dataHora', $dataHora);
            $stmt->bindParam(':vendedorID', $vendedorID);
            $stmt->bindParam(':valorProduto', $valorProduto);
            $stmt->bindParam(':valorFrete', $valorFrete);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir aquisição.");
            }

            $sqlUpdate = "UPDATE produto SET disponibilidade = 'vendido' WHERE produtoID = :produtoID";
            $stmtUpdate = $this->db->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':produtoID', $produtoID);

            if (!$stmtUpdate->execute()) {
                throw new Exception("Erro ao atualizar a disponibilidade do produto.");
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function atualizarAquisicaoIDPorProduto($produtoID) {
        $sql = "SELECT aquisicaoID FROM aquisicoes WHERE produtoID = :produtoID";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID);
        $stmt->execute();
        
        $aquisicao = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($aquisicao) {
            $aquisicaoID = $aquisicao['aquisicaoID'];

            $updateSql = "UPDATE compraspagamento SET aquisicaoID = :aquisicaoID WHERE produto_id = :produtoID"; // Mudado para produto_id
            
            $updateStmt = $this->db->prepare($updateSql);
            $updateStmt->bindParam(':aquisicaoID', $aquisicaoID);
            $updateStmt->bindParam(':produtoID', $produtoID);

            return $updateStmt->execute();
        }
        
        return false;
    }
    
}
?>
