<?php
require_once 'app/models/MeusAnunciosModel.php';

class MeusAnunciosController {
    private $meusAnunciosModel;

    public function __construct() {
        $this->meusAnunciosModel = new MeusAnunciosModel();
    }

    public function mostrarAnuncios() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userID = $_SESSION['user_id'];
        // Buscar todos os produtos do usuário
        $anuncios = $this->meusAnunciosModel->buscarProdutosPorUsuario($userID);

        // Se não houver anúncios, inicializar como array vazio
        if (!$anuncios) {
            $anuncios = [];
        }

        // Para cada produto, buscar o status de aquisição
        foreach ($anuncios as &$anuncio) {
            $aquisicao = $this->meusAnunciosModel->obterAquisicaoPorProduto($anuncio['produtoID']);
            if ($aquisicao) {
                $anuncio['statusAquisicao'] = $aquisicao['statusAquisicao'];
            } else {
                $anuncio['statusAquisicao'] = 'Não está na tabela aquisição';
            }
        }

        require_once 'app/views/header.php';
        require 'app/views/MeusAnuncios.php';
    }
}
