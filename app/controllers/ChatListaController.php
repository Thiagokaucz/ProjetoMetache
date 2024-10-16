<?php
session_start();

require_once 'app/models/ChatListaModel.php';

class ChatListaController {
    private $ChatListaModel;

    public function __construct() {
        $this->ChatListaModel = new ChatListaModel();
    }

    public function verificarUsuarioNoChat() {

        if (isset($_SESSION['user_id'])) { // Verifica se o usuário está logado
            $userChatId = $_SESSION['user_id']; // Obtém o ID do usuário da sessão

            // Obtém chats do vendedor e do comprador
            $ChatsCompras = $this->ChatListaModel->obterChatsCompras($userChatId);
            $ChatsVendas = $this->ChatListaModel->obterChatsVendas($userChatId);

            require_once 'app/views/header.php';
            require_once 'app/views/ChatLista.php';
            require_once 'app/views/footer.php';
        } else {
            header('Location: /login');
            exit();
        }
    }
}