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

        // Para cada produto, buscar o status de aquisição e o chatID
        foreach ($anuncios as &$anuncio) {
            // Obter a aquisição do produto
            $aquisicao = $this->meusAnunciosModel->obterAquisicaoPorProduto($anuncio['produtoID']);
            
            // Buscar o chatID associado ao produto
            $chatID = $this->meusAnunciosModel->buscarChatIDPorProdutoID($anuncio['produtoID']);
            
            // Verificar se a aquisição foi encontrada
            if ($aquisicao) {
                $anuncio['statusAquisicao'] = $aquisicao['statusAquisicao'];
                $anuncio['chatID'] = $chatID; // Adiciona o chatID ao anúncio
            } else {
                $anuncio['statusAquisicao'] = 'Não está na tabela aquisição';
                $anuncio['chatID'] = $chatID; // Pode ser null se não houver aquisição
            }
        }


        require_once 'app/views/header.php';
        require 'app/views/MeusAnuncios.php';
    }
}
