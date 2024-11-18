<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'app/models/EnviarProdutoModel.php';

class EnviarProdutoController {
    private $enviarProdutoModel;

    public function __construct() {
        $this->enviarProdutoModel = new EnviarProdutoModel();
    }

    public function mostrarFormulario() {
        $aquisicaoID = $_GET['aquisicaoID'] ?? null;

        if ($aquisicaoID === null) {
            echo "Erro: aquisicaoID não pode ser nulo.";
        }

        require_once 'app/views/header.php'; 
        require 'app/views/EnviarProduto.php'; 
    }

    public function enviarProduto() {
        session_start();
    
        $aquisicaoID = $_GET['aquisicaoID'] ?? null; 
        $transportadora = $_POST['transportadora'] ?? ''; 
        $codigoRastreio = $_POST['codigoRastreio'] ?? ''; 
        $comentario = $_POST['comentario'] ?? ''; 
        $dataHora = $_POST['dataHora'] ?? ''; 
    
        if ($aquisicaoID === null) {
            echo "Erro: aquisicaoID não pode ser nulo.";
            return; 
        }
    
        $this->enviarProdutoModel->gravarEnvioProduto($aquisicaoID, $transportadora, $codigoRastreio, $comentario, $dataHora);
    
        $this->enviarProdutoModel->atualizarStatusAquisicao($aquisicaoID);

    
        header('Location: /meusAnuncios');
        exit;
    }
    
}
