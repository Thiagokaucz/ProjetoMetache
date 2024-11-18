<?php
require_once 'app/models/CadastroPerguntasModel.php';

class CadastroPerguntasController {
    public function configurarPerguntas() {
        $errorMessage = '';
        $userID = $_GET['userID'] ?? null;

        if (!$userID) {
            echo 'ID de usuário inválido.';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pergunta1 = $_POST['pergunta1'] ?? null;
            $resposta1 = strtolower(trim($_POST['resposta1'] ?? ''));
            $pergunta2 = $_POST['pergunta2'] ?? null;
            $resposta2 = strtolower(trim($_POST['resposta2'] ?? ''));

            if ($pergunta1 && $resposta1 && $pergunta2 && $resposta2) {
                $model = new CadastroPerguntasModel();
                $model->salvarPerguntas($userID, $pergunta1, $resposta1, $pergunta2, $resposta2);
                header('Location: /login');
                exit();
            } elseif (isset($_POST['skip'])) {
                header('Location: /login');
                exit();
            } else {
                $errorMessage = 'Ambas as perguntas e respostas são obrigatórias, ou você pode pular essa etapa.';
            }
        }

        require 'app/views/cadastroPerguntas.php';
    }
}
