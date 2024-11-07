<?php
require_once 'app/models/CadastroModel.php';

class CadastroController {
    public function cadastrar() {
        $errorMessage = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtém os dados do formulário
            $nome = ucwords(strtolower(trim($_POST['nome'])));
            $sobrenome = ucwords(strtolower(trim($_POST['sobrenome'])));
            $email = trim($_POST['email']);
            $senha = $_POST['senha'];
            $cep = trim($_POST['cep']);

            // Validação dos dados
            if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha) || empty($cep)) {
                $errorMessage = 'Todos os campos são obrigatórios.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = 'Endereço de e-mail inválido.';
            } else {
                $userModel = new CadastroModel();
                if ($userModel->emailExists($email)) {
                    $errorMessage = 'Este e-mail já está registrado.';
                } else {
                    // Hash da senha
                    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
                    
                    // Cadastro do usuário e obtenção do ID
                    $userID = $userModel->cadastrar($nome, $sobrenome, $email, $senhaHash, $cep);
                    
                    // Redireciona para a tela de perguntas de segurança com o ID do usuário
                    header("Location: /cadastroPerguntas?userID=$userID");
                    exit();
                }
            }
        }

        require 'app/views/cadastro.php';
    }
}
