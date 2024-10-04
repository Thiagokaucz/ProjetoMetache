<?php
session_start();
require_once 'app/models/UserModel.php';

class CadastroController {
    public function cadastrar() {
        $errorMessage = ''; // Mensagem de erro

        // Verifica se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtém os dados do formulário
            $nome = trim($_POST['nome']);
            $sobrenome = trim($_POST['sobrenome']);
            $email = trim($_POST['email']);
            $senha = $_POST['senha'];
            $cep = trim($_POST['cep']);

            // Valida os dados
            if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha) || empty($cep)) {
                $errorMessage = 'Todos os campos são obrigatórios.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = 'Endereço de e-mail inválido.';
            } else {
                // Verifica se o e-mail já está registrado
                $userModel = new UserModel();
                if ($userModel->emailExists($email)) {
                    $errorMessage = 'Este e-mail já está registrado.';
                } else {
                    // Hashing da senha
                    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
                    $userModel->cadastrar($nome, $sobrenome, $email, $senhaHash, $cep);
                    header('Location: /login'); // Redireciona para login após cadastro
                    exit(); // Adicionando exit após o redirecionamento
                }
            }
        }

        // Carrega a view de cadastro e passa a mensagem de erro, se houver
        require 'app/views/cadastro.php';
    }
}
?>
