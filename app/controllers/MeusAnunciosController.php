<?php
require_once 'app/models/MeusAnunciosModel.php';

class MeusAnunciosController {
    private $meusAnunciosModel;

    public function __construct() {
        $this->meusAnunciosModel = new MeusAnunciosModel();
    }

    public function mostrarAnuncios() {
        // Pega o user_id da sessão
        session_start();
        if (!isset($_SESSION['user_id'])) {
            // Redireciona para o login se o usuário não estiver logado
            header('Location: /login');
            exit;
        }

        $userID = $_SESSION['user_id'];

        // Buscar os produtos criados pelo usuário logado
        $anuncios = $this->meusAnunciosModel->buscarProdutosPorUsuario($userID);

        // Para cada produto, verificar se está em aquisição
        foreach ($anuncios as &$anuncio) {
            $estaEmAquisicao = $this->meusAnunciosModel->verificarProdutoEmAquisicao($anuncio['produtoID']);
            $anuncio['statusAquisicao'] = $estaEmAquisicao ? 'Está em aquisição' : 'Não está em aquisição';
        }

        // Exibir os resultados
        require_once 'app/views/header.php';
        require 'app/views/MeusAnuncios.php';
    }
}
