<?php
require_once 'app/models/EnviarProdutoModel.php';

class EnviarProdutoController {
    private $enviarProdutoModel;

    public function __construct() {
        $this->enviarProdutoModel = new EnviarProdutoModel();
    }

    // Método para exibir o formulário
    public function mostrarFormulario() {
        // Obtendo o aquisicaoID da URL
        $aquisicaoID = $_GET['aquisicaoID'] ?? null;

        // Verifique se aquisicaoID não está nulo
        if ($aquisicaoID === null) {
            echo "Erro: aquisicaoID não pode ser nulo.";
            return; // Para evitar erro de execução se aquisicaoID for nulo
        }

        // Exibe o formulário
        require_once 'app/views/header.php'; // Carregar cabeçalho
        require 'app/views/EnviarProduto.php'; // Carregar a view do formulário
    }

    // Método para processar o envio do produto
    public function enviarProduto() {
        session_start();
    
        // Obtendo dados da URL
        $aquisicaoID = $_GET['aquisicaoID'] ?? null; // AquisicaoID recebido da URL
        $transportadora = $_POST['transportadora'] ?? ''; // Pegar do formulário
        $codigoRastreio = $_POST['codigoRastreio'] ?? ''; // Pegar do formulário
        $comentario = $_POST['comentario'] ?? ''; // Pegar do formulário
        $dataHora = $_POST['dataHora'] ?? ''; // Pegar data e hora do formulário
    
        // Verifique se aquisicaoID não está nulo
        if ($aquisicaoID === null) {
            echo "Erro: aquisicaoID não pode ser nulo.";
            return; // Para evitar erro de execução se aquisicaoID for nulo
        }
    
        // Grava na tabela envioProduto
        $this->enviarProdutoModel->gravarEnvioProduto($aquisicaoID, $transportadora, $codigoRastreio, $comentario, $dataHora);
    
        // Atualiza o status na tabela aquisicoes
        $this->enviarProdutoModel->atualizarStatusAquisicao($aquisicaoID);
    
        // Redireciona para uma página de sucesso ou para onde desejar
        header('Location: /meusAnuncios');
        exit;
    }
    
}
