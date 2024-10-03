<?php
require_once('app/models/User.php');

class LoginController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($senha, $user['senha'])) {
                session_start();
                $_SESSION['user_id'] = $user['userID'];
                $_SESSION['nome'] = $user['nome'];
                header('Location: /'); // Redireciona para uma página protegida
                exit();
            } else {
                $error = "Email ou senha incorretos!";
                require_once('app/views/header.php');
                require_once('app/views/login.php');
                require_once('app/views/footer.php');
            }
        } else {
            require_once('app/views/header.php');
            require_once('app/views/login.php');
            require_once('app/views/footer.php');
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
?>
