<?php
require_once 'config/Database.php';

class FinalizarCompraModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->obterConexao(); // Obtém a conexão PDO
    }

    public function finalizarCompra($produtoID, $chatID, $compradorID, $vendedorID) {
        // Obtém a data e hora atual
        $dataHora = date('Y-m-d H:i:s');

        // Prepara a consulta SQL
        $sql = "INSERT INTO aquisicoes (produtoID, chatID, compradorID, dataHora, vendedorID, statusAquisicao) 
                VALUES (:produtoID, :chatID, :compradorID, :dataHora, :vendedorID, 'em processamento')";

        // Usa a conexão PDO para preparar a declaração
        $stmt = $this->db->prepare($sql);
        
        // Liga os parâmetros
        $stmt->bindParam(':produtoID', $produtoID);
        $stmt->bindParam(':chatID', $chatID);
        $stmt->bindParam(':compradorID', $compradorID);
        $stmt->bindParam(':dataHora', $dataHora);
        $stmt->bindParam(':vendedorID', $vendedorID);

        // Executa a declaração e retorna o resultado
        return $stmt->execute();
    }
}
?>
