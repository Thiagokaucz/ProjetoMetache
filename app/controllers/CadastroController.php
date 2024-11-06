<?php
session_start();
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

            // Verifica se as perguntas e respostas foram fornecidas
            $pergunta1 = isset($_POST['pergunta1']) ? $_POST['pergunta1'] : null;
            $resposta1 = isset($_POST['resposta1']) ? strtolower(trim($_POST['resposta1'])) : null;
            $pergunta2 = isset($_POST['pergunta2']) ? $_POST['pergunta2'] : null;
            $resposta2 = isset($_POST['resposta2']) ? strtolower(trim($_POST['resposta2'])) : null;

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
                    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
                    $userModel->cadastrar($nome, $sobrenome, $email, $senhaHash, $cep, $pergunta1, $resposta1, $pergunta2, $resposta2);
                    header('Location: /login');
                    exit();
                }
            }
        }

        require 'app/views/cadastro.php';
    }
}
?>
