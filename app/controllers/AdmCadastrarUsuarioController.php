<?php

session_start();

require_once 'app/models/AdmCadastrarUsuarioModel.php';

class AdmCadastrarUsuarioController {
    public function mostrarFormularioCadastro() {
        
        include 'app/views/AdmHeader.php';
        require 'app/views/AdmCadastrarUsuario.php';
    }

    public function cadastrar() {
        $erroMensagem = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];

            $admModel = new AdmCadastrarUsuarioModel();
            $resultado = $admModel->cadastrarUsuario($nome, $usuario, $senha);

            if ($resultado) {
                header('Location: /admlogin');
                exit();
            } else {
                $erroMensagem = 'Erro ao cadastrar o usuário. Tente novamente.';
            }
        }

        require 'app/views/AdmCadastrarUsuario.php'; 
    }
}
