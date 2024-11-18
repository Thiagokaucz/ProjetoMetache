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
            SELECT m.*, lc.valorCompra, lc.visualizacao, u.nome AS nomeUsuario
            FROM mensagem m
            LEFT JOIN linkcompra lc ON m.linkcompra = lc.linkCompraID
            LEFT JOIN usuario u ON m.userID = u.userID
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
        
        $chat = $stmt->fetch(PDO::FETCH_ASSOC);

        return $chat ? $chat['chatID'] : null;
    }

        public function verificarChatVendedor($produtoID, $vendedorID) {

            $query = "SELECT chatID FROM chat WHERE produtoID = :produtoID AND vendedorID = :vendedorID LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':produtoID', $produtoID);
            $stmt->bindParam(':vendedorID', $vendedorID);
    
            $stmt->execute();
            
            $chat = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $chat ? $chat['chatID'] : null;
        }


        public function verificarOuCriarChat($produtoID, $compradorID, $vendedorID) {
            $query = "SELECT chatID FROM chat WHERE produtoID = :produtoID AND compradorID = :compradorID AND vendedorID = :vendedorID LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':produtoID', $produtoID);
            $stmt->bindParam(':compradorID', $compradorID);
            $stmt->bindParam(':vendedorID', $vendedorID);

            $stmt->execute();
            
            $chat = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($chat) {
                return $chat['chatID'];
            } else {
                $query = "INSERT INTO chat (produtoID, compradorID, vendedorID, DataInicioChat) VALUES (:produtoID, :compradorID, :vendedorID, NOW())";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':produtoID', $produtoID);
                $stmt->bindParam(':compradorID', $compradorID);
                $stmt->bindParam(':vendedorID', $vendedorID);
                $stmt->execute();

                return $this->conn->lastInsertId();

                $conteudoNotificacao = "Usuário " . $userID . " iniciou uma negociação no chat " . $chatId;
                $statusCriouNotificacao = $this->ChatMensagemModel->criarNotificacao($userID, $vendedorID, $chatId, $conteudoNotificacao);
            }
        }
   
        public function verificarExistenciaChat($chatID) {
            $sql = "SELECT COUNT(*) FROM notificacao WHERE chatID = :chatID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT); 
            $stmt->execute();
        
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

        public function buscarUserIDPorProdutoID($produtoID) {
            $query = "SELECT userID FROM produto WHERE produtoID = :produtoID LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':produtoID', $produtoID);

            $stmt->execute();
            
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            return $produto ? $produto['userID'] : null;
        }   

        public function salvarLinkCompra($chatId, $valorBrutoCompra, $valorCompra, $statusLinkCompra, $valorFrete, $produtoId) {
            $query = "INSERT INTO linkcompra (chatID, valorBrutoCompra, valorCompra, statusLinkCompra, valorFrete, produtoID) 
                      VALUES (:chatID, :valorBrutoCompra, :valorCompra, :statusLinkCompra, :valorFrete, :produtoID)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':chatID', $chatId);
            $stmt->bindParam(':valorBrutoCompra', $valorBrutoCompra);
            $stmt->bindParam(':valorCompra', $valorCompra);
            $stmt->bindParam(':statusLinkCompra', $statusLinkCompra);
            $stmt->bindParam(':valorFrete', $valorFrete);
            $stmt->bindParam(':produtoID', $produtoId); 
            $stmt->execute();
        
            return $this->conn->lastInsertId();
        }
        
        
        public function salvarMensagemComLinkCompra($chatId, $conteudo, $userId, $linkCompraID) {

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
            
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }
        
        
        public function cancelarLinkCompra($linkCompraID) {
            $query = "UPDATE linkcompra SET statusLinkCompra = 'cancelado' WHERE linkCompraID = :linkCompraID";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':linkCompraID', $linkCompraID);
            return $stmt->execute(); 
        }
        public function atualizarStatusLink($linkCompraID, $status) {
            $sql = "UPDATE linkcompra SET statusLinkCompra = :status WHERE linkCompraID = :linkCompraID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':linkCompraID', $linkCompraID);
            return $stmt->execute();
        }
        
        public function buscarProdutoPorID($produtoID) {

            $sql = "SELECT produtoID, titulo, locImagem, valor FROM produto WHERE produtoID = :produtoID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
            $stmt->execute();
        
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        
        public function excluirMensagemELinkCompra($linkCompraID) {
            $this->conn->beginTransaction();
    
            try {
                $stmt = $this->conn->prepare("DELETE FROM mensagem WHERE linkCompra = :linkCompraID");
                $stmt->bindParam(':linkCompraID', $linkCompraID);
                $stmt->execute();
    
                $stmt = $this->conn->prepare("DELETE FROM linkcompra WHERE linkCompraID = :linkCompraID");
                $stmt->bindParam(':linkCompraID', $linkCompraID);
                $stmt->execute();
    
                $this->conn->commit();
            } catch (Exception $e) {
                $this->conn->rollBack();
                throw new Exception("Erro ao excluir link de compra e mensagens: " . $e->getMessage());
            }
        }

    public function getVendedorNomePorChatID($chatID) {
        $sql = "SELECT u.nome AS nomeVendedor
                FROM chat c
                JOIN usuario u ON c.vendedorID = u.userID
                WHERE c.chatID = :chatID"; 

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT); 
        $stmt->execute(); 

        $result = $stmt->fetch(PDO::FETCH_ASSOC); 

        if ($result) {
            return $result['nomeVendedor'];
        } else {
            return null;
        }
    }

    public function getCompradorNomePorChatID($chatID) {
        $sql = "SELECT u.nome AS nomeComprador
                FROM chat c
                JOIN usuario u ON c.compradorID = u.userID
                WHERE c.chatID = :chatID"; 

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT); 
        $stmt->execute(); 

        $result = $stmt->fetch(PDO::FETCH_ASSOC); 

        if ($result) {
            return $result['nomeComprador'];
        } else {
            return null; 
        }
    }
    
    public function verificarDisponibilidadeProduto($produtoID) {
    $query = "SELECT disponibilidade FROM produto WHERE produtoID = :produtoID LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
    $stmt->execute();

    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    return $produto ? $produto['disponibilidade'] : null;
}

}
