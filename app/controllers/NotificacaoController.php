<?php
session_start();
require_once 'app/models/NotificacaoModel.php';

class NotificacaoController {
    private $notificacaoModel;

    public function __construct() {
        $this->notificacaoModel = new NotificacaoModel();
    }

    public function mostrarNotificacoes() {
        if (isset($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];
            $notificacoes = $this->notificacaoModel->getNotificacoesByUserID($userID);
            require_once 'app/views/header.php';
            require_once 'app/views/notificacao.php';
            require_once 'app/views/footerConfig.php';
        } else {
            header('Location: /login');
            exit();
        }
    }

    public function excluirNotificacao() {
        if (isset($_GET['id'])) {
            $notificacaoID = $_GET['id'];
            if ($this->notificacaoModel->deleteNotificacao($notificacaoID)) {
                header('Location: /notificacao');
                exit();
            } else {
                echo "Erro ao excluir notificação.";
            }
        } else {
            echo "ID da notificação não fornecido.";
        }
    }
}
?>
