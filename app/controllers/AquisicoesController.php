<?php
require_once 'app/models/AquisicoesModel.php';

class AquisicoesController {
    private $aquisicoesModel;

    public function __construct() {
        $this->aquisicoesModel = new AquisicoesModel();
    }

// AquisicoesController.php

public function mostrarAquisicoes() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    $userID = $_SESSION['user_id'];

    // Buscar as aquisições do usuário logado
    $aquisicoes = $this->aquisicoesModel->buscarAquisicoesPorUsuario($userID);

    // Usar array_map para transformar as aquisições
    $aquisicoes = array_map(function($aquisicao) {
        $produto = $this->aquisicoesModel->buscarProdutoPorID($aquisicao['produtoID']);
        $aquisicao['produto'] = $produto; // Associar os dados do produto

        // Adicionando a imagem do produto
        $imagemProduto = $this->aquisicoesModel->buscarImagemProdutoPorAquisicao($aquisicao['aquisicaoID']);
        $aquisicao['produto']['locImagem'] = $imagemProduto; // Adiciona a imagem do produto ao array

        // Se o status da aquisição for 'enviado', buscar detalhes do envio
        if ($aquisicao['statusAquisicao'] === 'enviado') {
            $envio = $this->aquisicoesModel->buscarEnvioPorAquisicaoID($aquisicao['aquisicaoID']);
            $aquisicao['envio'] = $envio; // Associar os dados de envio
        }

        return $aquisicao;
    }, $aquisicoes);

    require_once 'app/views/header.php';
    require 'app/views/Aquisicoes.php';
    require_once 'app/views/footerConfig.php';

    
}



public function receberProduto() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    // Obtendo o ID da aquisição
    $aquisicaoID = $_GET['aquisicaoID'] ?? null;

    if ($aquisicaoID) {
        // Atualiza o status da aquisição para 'produto entregue'
        if ($this->aquisicoesModel->atualizarStatusAquisicao($aquisicaoID, 'produto entregue')) {
            // Redireciona de volta à lista de aquisições com uma mensagem de sucesso
            $this->aquisicoesModel->atualizarStatusAdmMetache($aquisicaoID);
            header('Location: /minhasCompras');
        } else {
            // Redireciona com uma mensagem de erro
            header('Location: /minhasCompras');
        }
    } else {
        // Redireciona com mensagem de erro se o ID não foi fornecido
        header('Location: /minhasCompras');
    }
}

}
