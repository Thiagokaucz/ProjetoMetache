<?php
require_once 'app/models/AquisicoesModel.php';

class AquisicoesController {
    private $aquisicoesModel;

    public function __construct() {
        $this->aquisicoesModel = new AquisicoesModel();
    }

    public function mostrarAquisicoes() {
        // Pega o user_id da sessão (supondo que você tenha iniciado a sessão corretamente)
        session_start();
        if (!isset($_SESSION['user_id'])) {
            // Redireciona para o login se o usuário não estiver logado
            header('Location: /login');
            exit;
        }

        $userID = $_SESSION['user_id'];

        // Buscar as aquisições do usuário logado
        $aquisicoes = $this->aquisicoesModel->buscarAquisicoesPorUsuario($userID);

        // Para cada aquisição, buscar também os detalhes do produto
        foreach ($aquisicoes as &$aquisicao) {
            $produto = $this->aquisicoesModel->buscarProdutoPorID($aquisicao['produtoID']);
            $aquisicao['produto'] = $produto; // Associar os dados do produto
        }

        // Exibir os resultados
        require_once 'app/views/header.php';
        require 'app/views/Aquisicoes.php';
    }
}
