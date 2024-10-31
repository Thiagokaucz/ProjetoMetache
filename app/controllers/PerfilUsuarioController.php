<?php
session_start();
require_once 'app/models/PerfilUsuarioModel.php';

class PerfilUsuarioController {
    private $PerfilUsuarioModel;

    public function __construct() {
        $this->PerfilUsuarioModel = new PerfilUsuarioModel();
    }    

    // Exibe os dados do usuário logado
    public function exibirDados() {
        if (isset($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];
            $usuario = $this->PerfilUsuarioModel->buscarUsuarioPorID($userID);
            if ($usuario) {
                require_once 'app/views/header.php';
                require 'app/views/PerfilUsuario.php'; // View para exibir os dados do usuário
                require_once 'app/views/footerConfig.php';
            } else {
                echo "Usuário não encontrado.";
            }
        } else {
            header('Location: /login');
        }
    }

    // Atualiza os dados do usuário logado
    public function atualizarDados() {
        if (isset($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
                $sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);

                $resultado = $this->PerfilUsuarioModel->atualizarUsuario($userID, $nome, $sobrenome, $email, $cep);
                if ($resultado) {
                    echo "Dados atualizados com sucesso.";
                } else {
                    echo "Erro ao atualizar os dados.";
                }
            }
            $this->exibirDados(); // Reexibe os dados após atualização
        } else {
            header('Location: /login');
        }
    }

    // Desativa o usuário
    public function desativarUsuario() {
        if (isset($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];
            $resultado = $this->PerfilUsuarioModel->desativarUsuario($userID);
            
            if ($resultado) {
                session_destroy(); // Encerra a sessão após desativar a conta
                header('Location: /login');
            } else {
                echo "Erro ao desativar a conta.";
            }
        } else {
            header('Location: /login');
        }
    }
    
}
?>
