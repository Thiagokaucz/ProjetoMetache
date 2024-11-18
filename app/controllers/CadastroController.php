<?php
require_once 'app/models/CadastroModel.php';

class CadastroController {
    public function cadastrar() {
        $errorMessage = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = ucwords(strtolower(trim($_POST['nome'])));
            $sobrenome = ucwords(strtolower(trim($_POST['sobrenome'])));
            $email = trim($_POST['email']);
            $senha = $_POST['senha'];
            $cep = trim($_POST['cep']);

            if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha) || empty($cep)) {
                $errorMessage = 'Todos os campos são obrigatórios.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = 'Endereço de e-mail inválido.';
            } else {
                $userModel = new CadastroModel();
                if ($userModel->emailExists($email)) {
                    $errorMessage = 'Este e-mail já está registrado.';
                } else {
                    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
                    
                    $userID = $userModel->cadastrar($nome, $sobrenome, $email, $senhaHash, $cep);
                    
                    header("Location: /cadastroPerguntas?userID=$userID");
                    exit();
                }
            }
        }

        require 'app/views/cadastro.php';
    }
}
