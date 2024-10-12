<?php
session_start();

require_once 'app/models/ChatListaModel.php'; // Inclua o arquivo do model

class ChatListaController {
    private $ChatListaModel;

    public function __construct() {
        $this->ChatListaModel = new ChatListaModel();
    }

    public function verificarUsuarioNoChat() {
        if (isset($_SESSION['user_id'])) { // Verifica se o usuário está logado
            $userChatId = $_SESSION['user_id']; // Obtém o ID do usuário da sessão

            // Obtém chats do vendedor e do comprador
            $vendedorChats = $this->ChatListaModel->getChatsByUserID($userChatId);
            $compradorChats = $this->ChatListaModel->getChatsByCompradorID($userChatId);

            require_once 'app/views/header.php';
            require_once 'app/views/ChatLista.php'; // Uma única view para listar todos os chats
            require_once 'app/views/footer.php';
        } else {
            header('Location: /login'); // Redireciona para a página de login se não estiver logado
            exit();
        }
    }
}