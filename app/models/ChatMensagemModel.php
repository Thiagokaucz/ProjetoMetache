<?php
require_once 'config/Database.php';

class ChatMensagemModel {
    private $conn;

    public function __construct() {
        $database = new Database(); // Cria uma nova instância da classe Database
        $this->conn = $database->getConnection(); // Obtém a conexão
    }

    public function getMessagesByChatId($chatId) {
        $stmt = $this->conn->prepare("SELECT * FROM mensagem WHERE chatID = :chatId ORDER BY dataHora ASC");
        $stmt->bindParam(':chatId', $chatId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verifica se um chat existe para o produto e usuário fornecidos
    public function verificarOuCriarChat($produtoID, $userID, $destinatarioID) {
        // Verifica se já existe um chat com o produtoID, userID e destinatarioID
        $query = "SELECT chatID FROM chat WHERE produtoID = :produtoID AND userID = :userID AND destinatarioID = :destinatarioID LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':produtoID', $produtoID);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':destinatarioID', $destinatarioID);

        $stmt->execute();
        
        $chat = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($chat) {
            // Se o chat já existe, retorna o chatID
            return $chat['chatID'];
        } else {
            // Se não existe, cria um novo chat
            $query = "INSERT INTO chat (produtoID, userID, destinatarioID, DataInicioChat) VALUES (:produtoID, :userID, :destinatarioID, NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':produtoID', $produtoID);
            $stmt->bindParam(':userID', $userID);
            $stmt->bindParam(':destinatarioID', $destinatarioID);
            $stmt->execute();

            // Retorna o ID do novo chat
            return $this->conn->lastInsertId();
        }
    }

    // Função para buscar o userID a partir do produtoID
    public function buscarUserIDdeProduto($produtoID) {
        $query = "SELECT userID FROM produto WHERE produtoID = :produtoID LIMIT 1"; // Certifique-se de que a tabela produto e as colunas existem
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row

        if ($result) {
            return $result['userID']; // Retorna o userID
        } else {
            return null; // Retorna null se não encontrar o produto
        }
    }

    public function buscarProdutoIDPorChatID($chatID) {
        // Prepara a consulta para buscar o produtoID pelo chatID
        $query = "SELECT produtoID FROM chat WHERE chatID = :chatID LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT);
        $stmt->execute();
    
        // Recupera o resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verifica se encontrou o produtoID e retorna
        if ($result) {
            return $result['produtoID'];
        } else {
            return null; // Retorna null se não encontrar
        }
    }
    
}
