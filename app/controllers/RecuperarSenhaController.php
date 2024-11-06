<?php
session_start();
require_once 'app/models/RecuperarSenhaModel.php';

class RecuperarSenhaController {
    private $model;

    public function __construct() {
        $this->model = new RecuperarSenhaModel();
    }

    public function solicitarEmail() {
        $erroMensagem = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $usuario = $this->model->buscarUsuarioPorEmail($email);

            if ($usuario) {
                $_SESSION['recuperacao_email'] = $email; // Salva o e-mail para recuperação
                $_SESSION['pergunta1'] = $usuario['pergunta1'];
                $_SESSION['pergunta2'] = $usuario['pergunta2'];
                header('Location: /recuperarSenha/perguntas');
                exit();
            } else {
                $erroMensagem = 'E-mail não encontrado.';
            }
        }
        require 'app/views/recSenhaEmail.php';
    }

    public function validarPerguntas() {
        if (!isset($_SESSION['recuperacao_email'])) {
            header('Location: /recuperarSenha/email');
            exit();
        }

        $erroMensagem = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resposta1 = strtolower(trim($_POST['resposta1']));
            $resposta2 = strtolower(trim($_POST['resposta2']));
            $email = $_SESSION['recuperacao_email'];

            $usuario = $this->model->buscarUsuarioPorEmail($email);
            if ($usuario && $resposta1 === strtolower($usuario['resposta1']) && $resposta2 === strtolower($usuario['resposta2'])) {
                header('Location: /recuperarSenha/novaSenha');
                exit();
            } else {
                $erroMensagem = 'Respostas incorretas.';
            }
        }
        require 'app/views/recSenhaPerguntas.php';
    }

    public function redefinirSenha() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $novaSenha = password_hash($_POST['novaSenha'], PASSWORD_BCRYPT);
            $email = $_SESSION['recuperacao_email'];

            if ($this->model->atualizarSenha($email, $novaSenha)) {
                unset($_SESSION['recuperacao_email'], $_SESSION['pergunta1'], $_SESSION['pergunta2']);
                header('Location: /login');
                exit();
            }
        }
        require 'app/views/recSenhaNovaSenha.php';
 
    }
}