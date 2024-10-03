<?php
require_once('app/models/User.php');

class RegisterController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            if ($this->userModel->create($nome, $email, $senha)) {
                header('Location: /login');
                exit();
            } else {
                $error = "Erro ao criar usuário!";
                require_once('app/views/header.php');
                require_once('app/views/register.php');
                require_once('app/views/footer.php');
            }
        } else {
            require_once('app/views/header.php');
            require_once('app/views/register.php');
            require_once('app/views/footer.php');
        }
    }
}
?>
