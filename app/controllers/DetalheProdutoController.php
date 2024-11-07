<?php
session_start();
require_once 'app/models/DetalheProdutoModel.php';

class DetalheProdutoController {
    private $produtoModel;

    public function __construct() {
        $database = new Database();
        $this->produtoModel = new ProductModel($database);
    }

    public function mostrarDetalhes() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $noChat = isset($_GET['noChat']); // Verifica se o parâmetro "noChat" está presente
    
        if ($id) {
            $produto = $this->produtoModel->getProdutoById($id);
            if ($produto) {
                $this->produtoModel->incrementarVisualizacao($id);
                $userAnuncio = $this->produtoModel->getUserIDByProductId($id);
                $totalVendas = $this->produtoModel->contarVendasPorVendedor($userAnuncio);
                $totalDenuncias = $this->produtoModel->contarDenunciasPorVendedor($userAnuncio);
    
                require_once 'app/views/header.php';
                require_once 'app/views/detalheProduto.php';
                require_once 'app/views/footer.php';
            } else {
                http_response_code(404);
                require_once 'app/views/error.php';
            }
        } else {
            http_response_code(400);
            echo "ID do produto não fornecido.";
        }
    }
    
}
