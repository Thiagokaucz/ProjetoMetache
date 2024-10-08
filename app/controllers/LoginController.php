<?php
session_start();

require_once 'app/models/UserModel.php';

class LoginController {
    public function login() {
        $errorMessage = ''; // Variável para armazenar mensagens de erro

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $userModel = new UserModel();
            $user = $userModel->login($email, $senha);

            if ($user) {
                $_SESSION['user_id'] = $user['userID'];
                $_SESSION['user_name'] = $user['nome']; // Armazena o nome na sessão
                header('Location: /'); // Redireciona após login
                exit(); // Adiciona exit após redirecionamento
            } else {
                $errorMessage = 'Usuário ou senha inválidos.'; // Armazena mensagem de erro
            }
        }

        // Passa a mensagem de erro para a view
        require 'app/views/login.php'; // Carrega a view de login com a mensagem
    }

    public function logout() {
        session_start(); // Inicia a sessão
        session_destroy(); // Destroi a sessão
        header('Location: /'); // Redireciona para a página de login
        exit(); // Adiciona exit após o redirecionamento
    }
}
?>
