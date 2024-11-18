<?php
session_start();

require_once 'app/models/AdmLoginModel.php';

class AdmLoginController {
    public function login() {
        $erroMensagem = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];

            $admModel = new AdmLogin();
            $admin = $admModel->login($usuario, $senha);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['adminID'];
                $_SESSION['admin_name'] = $admin['nome'];
                $_SESSION['cargo'] = $admin['cargo'];  
                header('Location: /homeadm'); 
                exit();
            } else {
                $erroMensagem = 'Usuário ou senha incorretos.';
            }
        }

        require 'app/views/AdmLogin.php'; 
    }

    public function logout() {
        session_destroy();
        header('Location: /admlogin'); 
        exit();
    }
}
