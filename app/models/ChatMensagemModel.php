<?php
require_once 'config/Database.php';

class ChatMensagemModel {
    private $conn;

    public function __construct() {
        $database = new Database(); // Cria uma nova instância da classe Database
        $this->conn = $database->obterConexao(); // Obtém a conexão
    }

    public function getMessagesByChatId($chatId) {
        $stmt = $this->conn->prepare("SELECT * FROM mensagem WHERE chatID = :chatId ORDER BY dataHora ASC");
        $stmt->bindParam(':chatId', $chatId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarChatComprador($produtoID, $compradorID) {

        $query = "SELECT chatID FROM chat WHERE produtoID = :produtoID AND compradorID = :compradorID LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':produtoID', $produtoID);
        $stmt->bindParam(':compradorID', $compradorID);

        $stmt->execute();
        
        // Obtém o resultado
        $chat = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se encontrar um chat, retorna o chatID, caso contrário, retorna null
        return $chat ? $chat['chatID'] : null;
    }

        public function verificarChatVendedor($produtoID, $vendedorID) {

            $query = "SELECT chatID FROM chat WHERE produtoID = :produtoID AND vendedorID = :vendedorID LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':produtoID', $produtoID);
            $stmt->bindParam(':vendedorID', $vendedorID);
    
            $stmt->execute();
            
            // Obtém o resultado
            $chat = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Se encontrar um chat, retorna o chatID, caso contrário, retorna null
            return $chat ? $chat['chatID'] : null;
        }


        // Verifica se um chat existe para o produto e usuário fornecidos
        public function verificarOuCriarChat($produtoID, $compradorID, $vendedorID) {
            // Verifica se já existe um chat com o produtoID, compradorID e vendedorID
            $query = "SELECT chatID FROM chat WHERE produtoID = :produtoID AND compradorID = :compradorID AND vendedorID = :vendedorID LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':produtoID', $produtoID);
            $stmt->bindParam(':compradorID', $compradorID);
            $stmt->bindParam(':vendedorID', $vendedorID);

            $stmt->execute();
            
            $chat = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($chat) {
                // Se o chat já existe, retorna o chatID
                return $chat['chatID'];
            } else {
                // Se não existe, cria um novo chat
                $query = "INSERT INTO chat (produtoID, compradorID, vendedorID, DataInicioChat) VALUES (:produtoID, :compradorID, :vendedorID, NOW())";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':produtoID', $produtoID);
                $stmt->bindParam(':compradorID', $compradorID);
                $stmt->bindParam(':vendedorID', $vendedorID);
                $stmt->execute();

                // Retorna o ID do novo chat
                return $this->conn->lastInsertId();
            }
        }

        // Busca o userID a partir do produtoID na tabela produto
        public function buscarUserIDPorProdutoID($produtoID) {
            // Consulta para buscar o userID com base no produtoID
            $query = "SELECT userID FROM produto WHERE produtoID = :produtoID LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':produtoID', $produtoID);

            $stmt->execute();
            
            // Obtém o resultado
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            // Se encontrar o produto, retorna o userID, caso contrário, retorna null
            return $produto ? $produto['userID'] : null;
        }   
    
}
