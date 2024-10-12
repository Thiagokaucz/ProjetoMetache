<?php
session_start();

require_once 'app/models/ChatMensagemModel.php'; // Inclua o arquivo do model

class ChatMensagemController {
    
    private $ChatMensagemModel;

    public function __construct() {
        $this->ChatMensagemModel = new ChatMensagemModel();
    }

    public function chat() {
        // Verifica se o ID do chat foi passado na URL
        if (isset($_GET['id'])) {
            $chatId = $_GET['id']; // Obtém o ID do chat

            // Busca as mensagens desse chat
            $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId); 

            // Passa as mensagens para a visualização
            require_once 'app/views/header.php';
            require_once 'app/views/chatMensagem.php'; // Chama a tela passando as mensagens
            require_once 'app/views/footer.php';
        } else {
            echo "ID do chat não fornecido.";
        }
    }

    public function sendMessage() {
        // Verifica se a requisição é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém o ID do chat e a mensagem do formulário
            $chatId = $_POST['chatId'];
            $messageContent = $_POST['message'];

            // Obtém o ID do usuário da sessão
            $userId = $_SESSION['user_id'];

            // Insere a mensagem na tabela
            $this->saveMessage($chatId, $messageContent, $userId);

            // Redireciona de volta para a página do chat
            header("Location: /chat?id=$chatId");
            exit(); // Sempre chame exit após redirecionar
        } else {
            echo "Método não permitido.";
        }
    }

    // Método para salvar a mensagem no banco de dados
    private function saveMessage($chatId, $messageContent, $userId) {
        $database = new Database();
        $pdo = $database->getConnection();
        
        $stmt = $pdo->prepare("INSERT INTO mensagem (conteudo, dataHora, chatID, userID) VALUES (:conteudo, NOW(), :chatID, :userID)");
        $stmt->bindParam(':conteudo', $messageContent);
        $stmt->bindParam(':chatID', $chatId);
        $stmt->bindParam(':userID', $userId);
        
        return $stmt->execute(); // Executa a query e retorna o resultado
    }

    // Método para obter as mensagens via AJAX
    public function getMessagesAjax() {
        // Verifica se o ID do chat foi passado via requisição GET
        if (isset($_GET['id'])) {
            $chatId = $_GET['id'];

            // Busca as mensagens desse chat
            $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);

            // Retorna as mensagens como JSON
            header('Content-Type: application/json');
            echo json_encode($messages);
            exit(); // Sempre chame exit após enviar a resposta
        } else {
            echo json_encode(["error" => "ID do chat não fornecido."]);
            exit();
        }
    }
}
