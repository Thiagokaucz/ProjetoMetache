<?php
require_once 'config/Database.php';

class FinalizarCompraModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->obterConexao(); // Obtém a conexão PDO
    }
    public function finalizarCompra($produtoID, $chatID, $compradorID, $vendedorID, $valorProduto, $valorFrete) {
        // Inicia uma transação para garantir que ambas operações sejam feitas corretamente
        $this->db->beginTransaction();

        try {
            // Obtém a data e hora atual
            $dataHora = date('Y-m-d H:i:s');

            // Inserir a nova aquisição na tabela aquisicoes
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

            // Executa a inserção
            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir aquisição.");
            }

            // Atualizar a disponibilidade do produto para 'vendido'
            $sqlUpdate = "UPDATE produto SET disponibilidade = 'vendido' WHERE produtoID = :produtoID";
            $stmtUpdate = $this->db->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':produtoID', $produtoID);

            if (!$stmtUpdate->execute()) {
                throw new Exception("Erro ao atualizar a disponibilidade do produto.");
            }

            // Confirma a transação
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            // Em caso de erro, desfaz a transação
            $this->db->rollBack();
            return false;
        }
    }

    public function atualizarAquisicaoIDPorProduto($produtoID) {
        // Primeiro, busca a aquisicaoID na tabela aquisicoes
        $sql = "SELECT aquisicaoID FROM aquisicoes WHERE produtoID = :produtoID";
        
        // Prepara a declaração
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID);
        $stmt->execute();
        
        // Busca o resultado
        $aquisicao = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verifica se a aquisicaoID foi encontrada
        if ($aquisicao) {
            $aquisicaoID = $aquisicao['aquisicaoID'];

            // Agora, atualiza a tabela compraspagamento
            $updateSql = "UPDATE compraspagamento SET aquisicaoID = :aquisicaoID WHERE produto_id = :produtoID"; // Mudado para produto_id
            
            // Prepara a declaração para a atualização
            $updateStmt = $this->db->prepare($updateSql);
            $updateStmt->bindParam(':aquisicaoID', $aquisicaoID);
            $updateStmt->bindParam(':produtoID', $produtoID);

            // Executa a atualização
            return $updateStmt->execute();
        }
        
        // Retorna false se não encontrou a aquisicaoID
        return false;
    }
}
?>
