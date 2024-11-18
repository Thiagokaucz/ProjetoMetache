<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once 'app/models/ChatListaModel.php';

class ChatListaController {
    private $ChatListaModel;

    public function __construct() {
        $this->ChatListaModel = new ChatListaModel();
    }

    public function verificarUsuarioNoChat() {
        if (isset($_SESSION['user_id'])) { 
            $userChatId = $_SESSION['user_id']; 

            $ChatsCompras = $this->ChatListaModel->obterChatsCompras($userChatId);
            $ChatsVendas = $this->ChatListaModel->obterChatsVendas($userChatId);

            require_once 'app/views/header.php';
            require_once 'app/views/ChatLista.php';
            require_once 'app/views/footerConfig.php';
        } else {
            header('Location: /login');
            exit();
        }
    }

    public function excluirChat() {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $chatID = $_GET['id'];
            $this->ChatListaModel->excluirChatPorID($chatID);
            header('Location: /chatLista'); 
            exit();
        } else {
            header('Location: /chatLista');
            exit();
        }
    }
}
