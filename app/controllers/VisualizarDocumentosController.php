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
        if (isset($_GET['id'])) {
            $produtoId = htmlspecialchars($_GET['id']);
            
            $documentos = $this->documentosModel->buscarDocumentosPorProdutoId($produtoId);

            if ($documentos) {
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
