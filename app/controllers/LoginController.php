<?php
session_start();

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
    }
    

    public function logout() {
        session_start(); 
        session_destroy(); 
        header('Location: /'); 
        exit(); 
    }
}
?>
