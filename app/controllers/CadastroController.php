<?php
<<<<<<< HEAD
session_start();
<<<<<<< HEAD
require_once 'app/models/UserModel.php';
=======
require_once 'app/models/CadastroModel.php';
>>>>>>> 8dd99ddb18599ff97171806917c64fa4cb65d2ec

class CadastroController {
    public function cadastrar() {
        $errorMessage = ''; // Mensagem de erro

        // Verifica se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtém os dados do formulário
            $nome = trim($_POST['nome']);
            $sobrenome = trim($_POST['sobrenome']);
=======
require_once 'app/models/CadastroModel.php';

class CadastroController {
    public function cadastrar() {
        $errorMessage = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = ucwords(strtolower(trim($_POST['nome'])));
            $sobrenome = ucwords(strtolower(trim($_POST['sobrenome'])));
>>>>>>> develop
            $email = trim($_POST['email']);
            $senha = $_POST['senha'];
            $cep = trim($_POST['cep']);

<<<<<<< HEAD
            // Valida os dados
=======
>>>>>>> develop
            if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha) || empty($cep)) {
                $errorMessage = 'Todos os campos são obrigatórios.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = 'Endereço de e-mail inválido.';
            } else {
<<<<<<< HEAD
                // Verifica se o e-mail já está registrado
<<<<<<< HEAD
                $userModel = new UserModel();
=======
                $userModel = new CadastroModel();
>>>>>>> 8dd99ddb18599ff97171806917c64fa4cb65d2ec
                if ($userModel->emailExists($email)) {
                    $errorMessage = 'Este e-mail já está registrado.';
                } else {
                    // Hashing da senha
                    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
                    $userModel->cadastrar($nome, $sobrenome, $email, $senhaHash, $cep);
                    header('Location: /login'); // Redireciona para login após cadastro
                    exit(); // Adicionando exit após o redirecionamento
=======
                $userModel = new CadastroModel();
                if ($userModel->emailExists($email)) {
                    $errorMessage = 'Este e-mail já está registrado.';
                } else {
                    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
                    
                    $userID = $userModel->cadastrar($nome, $sobrenome, $email, $senhaHash, $cep);
                    
                    header("Location: /cadastroPerguntas?userID=$userID");
                    exit();
>>>>>>> develop
                }
            }
        }

<<<<<<< HEAD
        // Carrega a view de cadastro e passa a mensagem de erro, se houver
        require 'app/views/cadastro.php';
    }
}
?>
=======
        require 'app/views/cadastro.php';
    }
}
>>>>>>> develop
