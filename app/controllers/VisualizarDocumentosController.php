<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'app/models/VisualizarDocumentosModel.php';

class VisualizarDocumentosController {
    private $documentosModel;

    public function __construct() {
        $this->documentosModel = new VisualizarDocumentosModel();
    }

    public function exibirDocumentos() {
        // Verifica se o ID do produto foi passado na URL
        if (isset($_GET['id'])) {
            $produtoId = htmlspecialchars($_GET['id']);
            
            // Busca os documentos pelo ID do produto
            $documentos = $this->documentosModel->buscarDocumentosPorProdutoId($produtoId);

            if ($documentos) {
                // Exibe a view, passando os caminhos dos documentos
                    require_once 'app/views/header.php';
                    require 'app/views/visualizarDocumentosView.php';

            } else {
                echo "Documentos não encontrados para o ID do produto fornecido.";
            }
        } else {
            echo "ID do produto não fornecido.";
        }
    }
}
?>
