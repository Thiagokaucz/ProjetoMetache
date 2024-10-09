<?php
session_start();

require_once 'app/models/ChatModel.php'; // Inclua o arquivo do model

class ChatController {
    private $chatModel;

    public function __construct() {
        $this->chatModel = new ChatModel();
    }

    public function verificarUsuarioNoChat() {
        if (isset($_SESSION['user_id'])) { // Verifica se o usuário está logado
            $userChatId = $_SESSION['user_id']; // Obtém o ID do usuário da sessão

            // Obtém chats do vendedor e do comprador
            $vendedorChats = $this->chatModel->getChatsByUserID($userChatId);
            $compradorChats = $this->chatModel->getChatsByCompradorID($userChatId);

            require_once 'app/views/header.php';
            require_once 'app/views/ChatLista.php'; // Uma única view para listar todos os chats
            require_once 'app/views/footer.php';
        } else {
            header('Location: /login'); // Redireciona para a página de login se não estiver logado
            exit();
        }
    }
}
