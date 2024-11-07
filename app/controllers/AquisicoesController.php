<?php
session_start();
require_once 'app/models/AquisicoesModel.php';

class AquisicoesController {
    private $aquisicoesModel;

    public function __construct() {
        $this->aquisicoesModel = new AquisicoesModel();
    }

// AquisicoesController.php

    public function mostrarAquisicoes() { 

        // Redireciona para a página de login se o usuário não estiver logado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $userID = $_SESSION['user_id'];
        $aquisicoes = $this->aquisicoesModel->buscarAquisicoesPorUsuario($userID);

        $aquisicoes = array_map(function($aquisicao) {
            $produto = $this->aquisicoesModel->buscarProdutoPorID($aquisicao['produtoID']);
            $aquisicao['produto'] = $produto;

            $imagemProduto = $this->aquisicoesModel->buscarImagemProdutoPorAquisicao($aquisicao['aquisicaoID']);
            $aquisicao['produto']['locImagem'] = $imagemProduto;

            if ($aquisicao['statusAquisicao'] === 'enviado') {
                $envio = $this->aquisicoesModel->buscarEnvioPorAquisicaoID($aquisicao['aquisicaoID']);
                $aquisicao['envio'] = $envio;
            }

            return $aquisicao;
        }, $aquisicoes);

        require_once 'app/views/header.php';
        require 'app/views/Aquisicoes.php';
        require_once 'app/views/footerConfig.php';
    }


    public function receberProduto() {
        // Redireciona para a página de login se o usuário não estiver logado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $aquisicaoID = $_GET['aquisicaoID'] ?? null;

        if ($aquisicaoID) {
            if ($this->aquisicoesModel->atualizarStatusAquisicao($aquisicaoID, 'produto entregue')) {
                $this->aquisicoesModel->atualizarStatusAdmMetache($aquisicaoID);
                header('Location: /minhasCompras');
            } else {
                header('Location: /minhasCompras');
            }
        } else {
            header('Location: /minhasCompras');
        }
    }
    public function atualizarStatusAquisicoes() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'Usuário não autenticado']);
            exit();
        }
    
        $userID = $_SESSION['user_id'];
        $aquisicoes = $this->aquisicoesModel->buscarAquisicoesPorUsuario($userID);
    
        $aquisicoes = array_map(function($aquisicao) {
            $produto = $this->aquisicoesModel->buscarProdutoPorID($aquisicao['produtoID']);
            $aquisicao['produto'] = $produto;
    
            if ($aquisicao['statusAquisicao'] === 'enviado') {
                $envio = $this->aquisicoesModel->buscarEnvioPorAquisicaoID($aquisicao['aquisicaoID']);
                $aquisicao['envio'] = $envio;
            }
    
            return $aquisicao;
        }, $aquisicoes);
    
        echo json_encode($aquisicoes);
        exit();
    }
    
}
