<?php
require_once 'app/models/MeusAnunciosModel.php';
session_start();

class MeusAnunciosController {
    private $meusAnunciosModel;

    public function __construct() {
        $this->meusAnunciosModel = new MeusAnunciosModel();
    }

    public function mostrarAnuncios() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userID = $_SESSION['user_id'];
        $anuncios = $this->meusAnunciosModel->buscarProdutosPorUsuario($userID);

        if (!$anuncios) {
            $anuncios = [];
        }

        foreach ($anuncios as &$anuncio) {
            $aquisicao = $this->meusAnunciosModel->obterAquisicaoPorProduto($anuncio['produtoID']);
            $chatID = $this->meusAnunciosModel->buscarChatIDPorProdutoID($anuncio['produtoID']);
            
            if ($aquisicao) {
                $anuncio['statusAquisicao'] = $aquisicao['statusAquisicao'];
                $anuncio['chatID'] = $chatID;
            } else {
                $anuncio['statusAquisicao'] = 'Anunciado';
                $anuncio['chatID'] = $chatID;
            }
        }

        require_once 'app/views/header.php';
        require 'app/views/MeusAnuncios.php';
        require_once 'app/views/footerConfig.php';
    }

    public function alterarDisponibilidade() {
        if (isset($_GET['id']) && isset($_GET['acao'])) {
            $produtoID = $_GET['id'];
            $acao = $_GET['acao'];
            $user_id = $_SESSION['user_id'];
            $anuncio = $this->meusAnunciosModel->obterAnuncioPorID($produtoID);

            if ($anuncio && $anuncio['userID'] == $user_id) {
                if ($acao === 'pausar') {
                    $novaDisponibilidade = 'pausado';
                } elseif ($acao === 'liberar') {
                    $novaDisponibilidade = 'disponível';
                } else {
                    echo "Ação inválida!";
                    exit;
                }

                $this->meusAnunciosModel->atualizarDisponibilidade($produtoID, $novaDisponibilidade);
                header("Location: /meusAnuncios");
                exit;
            } else {
                echo "Você não tem permissão para alterar este anúncio.";
            }
        } else {
            echo "ID ou Ação não especificados!";
        }
    }

    public function excluirAnuncio() {
        if (isset($_GET['id'])) {
            $produtoID = $_GET['id'];
            $user_id = $_SESSION['user_id'];
            $anuncio = $this->meusAnunciosModel->obterAnuncioPorID($produtoID);

            if ($anuncio && $anuncio['userID'] == $user_id && 
               ($anuncio['disponibilidade'] === 'disponível' || $anuncio['disponibilidade'] === 'pausado')) {
                $this->meusAnunciosModel->excluirAnuncioPorID($produtoID);
                header("Location: /meusAnuncios");
                exit;
            } else {
                echo "Você não tem permissão para excluir este anúncio ou o anúncio não pode ser excluído.";
            }
        } else {
            echo "ID do anúncio não especificado!";
        }
    }
}
