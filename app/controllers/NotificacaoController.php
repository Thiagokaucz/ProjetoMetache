<?php
session_start();
require_once 'app/models/NotificacaoModel.php';

class NotificacaoController {
    private $notificacaoModel;

    // Construtor correto
    public function __construct() {
        $this->notificacaoModel = new NotificacaoModel();
    }

    // Função para exibir todas as notificações de um usuário
    public function mostrarNotificacoes() {
        if (isset($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];

            // Obtém todas as notificações do usuário
            $notificacoes = $this->notificacaoModel->getNotificacoesByUserID($userID);

            // Exibe a view de notificações
            require_once 'app/views/header.php';
            require_once 'app/views/notificacao.php';
            require_once 'app/views/footerConfig.php';
        } else {
            header('Location: /login');
            exit();
        }
    }

    public function excluirNotificacao() {
        // Verifica se o ID da notificação foi passado na URL
        if (isset($_GET['id'])) {
            $notificacaoID = $_GET['id']; // Obtém o ID da notificação
    
            // Chama o método do modelo para excluir a notificação
            if ($this->notificacaoModel->deleteNotificacao($notificacaoID)) {
                // Redireciona para a lista de notificações após excluir
                header('Location: /notificacao'); // Ajuste o caminho se necessário
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
