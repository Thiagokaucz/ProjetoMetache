<?php
session_start();

<<<<<<< HEAD
<<<<<<< HEAD
require_once 'app/models/UserModel.php';

class LoginController {
    public function login() {
        $errorMessage = ''; // Variável para armazenar mensagens de erro
=======
require_once 'app/models/LoginModel.php';

class LoginController {
    public function login() {
        $erroMensagem = '';
>>>>>>> 8dd99ddb18599ff97171806917c64fa4cb65d2ec

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

<<<<<<< HEAD
            $userModel = new UserModel();
=======
            $userModel = new LoginModel();
>>>>>>> 8dd99ddb18599ff97171806917c64fa4cb65d2ec
            $user = $userModel->login($email, $senha);

            if ($user) {
                $_SESSION['user_id'] = $user['userID'];
                $_SESSION['user_name'] = $user['nome']; // Armazena o nome na sessão
<<<<<<< HEAD
                header('Location: /home'); // Redireciona após login
                exit(); // Adiciona exit após redirecionamento
            } else {
                $errorMessage = 'Usuário ou senha inválidos.'; // Armazena mensagem de erro
=======
                header('Location: /'); // Redireciona após login
                exit(); // Adiciona exit após redirecionamento
            } else {
                $erroMensagem = 'Usuário ou senha inválidos.'; // Armazena mensagem de erro
>>>>>>> 8dd99ddb18599ff97171806917c64fa4cb65d2ec
            }
        }

        // Passa a mensagem de erro para a view
        require 'app/views/login.php'; // Carrega a view de login com a mensagem
=======
require_once 'app/models/LoginModel.php';

class LoginController {
    public function login() {
        $erroMensagem = '';
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
    
            $userModel = new LoginModel();
            $user = $userModel->login($email, $senha);
    
            if ($user === 'desativada') {
                $erroMensagem = 'Sua conta foi desativada. Entre em contato com o suporte para mais informações.';
            } elseif ($user) {
                $_SESSION['user_id'] = $user['userID'];
                $_SESSION['user_name'] = $user['nome']; 
                header('Location: /'); 
                exit(); 
            } else {
                $erroMensagem = 'Usuário ou senha inválidos.'; 
            }
        }
    
        require 'app/views/login.php'; 
>>>>>>> develop
    }
    

    public function logout() {
<<<<<<< HEAD
        session_start(); // Inicia a sessão
        session_destroy(); // Destroi a sessão
        header('Location: /'); // Redireciona para a página de login
        exit(); // Adiciona exit após o redirecionamento
=======
        session_start(); 
        session_destroy(); 
        header('Location: /'); 
        exit(); 
>>>>>>> develop
    }
}
?>
