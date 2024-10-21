<?php
require_once 'config/Database.php';

class ChatMensagemModel {
    private $conn;

    public function __construct() {
        $database = new Database(); // Cria uma nova instância da classe Database
        $this->conn = $database->obterConexao(); // Obtém a conexão
    }

    public function getMessagesByChatId($chatId) {
        $stmt = $this->conn->prepare("
            SELECT m.*, lc.valorCompra 
            FROM mensagem m
            LEFT JOIN linkCompra lc ON m.chatID = lc.chatID 
            WHERE m.chatID = :chatId 
            ORDER BY m.dataHora ASC
        ");
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

                $conteudoNotificacao = "Usuário " . $userID . " iniciou uma negociação no chat " . $chatId;
                $statusCriouNotificacao = $this->ChatMensagemModel->criarNotificacao($userID, $vendedorID, $chatId, $conteudoNotificacao);
            }
        }
   
        public function verificarExistenciaChat($chatID) {
            // Prepara a consulta para verificar se o chat existe
            $sql = "SELECT COUNT(*) FROM notificacao WHERE chatID = :chatID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT); // Certifica-se de usar o tipo correto
            $stmt->execute();
        
            // Verifica o resultado e retorna true se o chat existir, false caso contrário
            return $stmt->fetchColumn() > 0;
        }
        

        public function criarNotificacao($userID, $destinatarioID, $chatID, $conteudo) {
            $sql = "INSERT INTO notificacao (userID, destinatarioID, chatID, conteudo, dataHora) VALUES (:userID, :destinatarioID, :chatID, :conteudo, NOW())";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':userID', $userID);
            $stmt->bindParam(':destinatarioID', $destinatarioID);
            $stmt->bindParam(':chatID', $chatID);
            $stmt->bindParam(':conteudo', $conteudo);
    
            return $stmt->execute();
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

        public function salvarLinkCompra($chatId, $valorBrutoCompra, $valorCompra, $statusLinkCompra, $valorFrete, $produtoId) {
            // Inserir o link de compra na tabela 'linkcompra'
            $query = "INSERT INTO linkcompra (chatID, valorBrutoCompra, valorCompra, statusLinkCompra, valorFrete, produtoID) 
                      VALUES (:chatID, :valorBrutoCompra, :valorCompra, :statusLinkCompra, :valorFrete, :produtoID)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':chatID', $chatId);
            $stmt->bindParam(':valorBrutoCompra', $valorBrutoCompra);
            $stmt->bindParam(':valorCompra', $valorCompra);
            $stmt->bindParam(':statusLinkCompra', $statusLinkCompra);
            $stmt->bindParam(':valorFrete', $valorFrete);
            $stmt->bindParam(':produtoID', $produtoId); // Adiciona o produtoID
            $stmt->execute();
        
            // Retornar o ID do link de compra recém-criado
            return $this->conn->lastInsertId();
        }
        
        
        public function salvarMensagemComLinkCompra($chatId, $conteudo, $userId, $linkCompraID) {
            // Inserir a mensagem na tabela 'mensagem' com o ID do link de compra
            $query = "INSERT INTO mensagem (conteudo, dataHora, chatID, userID, linkcompra) 
                      VALUES (:conteudo, NOW(), :chatID, :userID, :linkcompra)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':conteudo', $conteudo);
            $stmt->bindParam(':chatID', $chatId);
            $stmt->bindParam(':userID', $userId);
            $stmt->bindParam(':linkcompra', $linkCompraID);
            $stmt->execute();
        }
        public function verificarLinkExistente($chatId) {
            $sql = "SELECT linkCompraID, dataHora FROM linkcompra WHERE chatID = :chatID AND statusLinkCompra = 'pendente'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':chatID', $chatId);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do link se existir
        }
        
        
        public function cancelarLinkCompra($linkCompraID) {
            $query = "UPDATE linkcompra SET statusLinkCompra = 'cancelado' WHERE linkCompraID = :linkCompraID";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':linkCompraID', $linkCompraID);
            return $stmt->execute(); // Executa e retorna se deu certo
        }
        public function atualizarStatusLink($linkCompraID, $status) {
            $sql = "UPDATE linkcompra SET statusLinkCompra = :status WHERE linkCompraID = :linkCompraID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':linkCompraID', $linkCompraID);
            return $stmt->execute();
        }
        
    
}
