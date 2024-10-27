<?php
session_start();

require_once 'app/models/DetalheProdutoModel.php';

class DetalheProdutoController {
    private $produtoModel;

    // Construtor
    public function __construct() {
        $database = new Database(); // Instancia a classe de conexão
        $this->produtoModel = new ProductModel($database); // Passa a instância de Database para o ProductModel
    }

    // Método para mostrar os detalhes do produto
    public function mostrarDetalhes() {
        // Pega o id da URL
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id) {
            // Busca o produto pelo id
            $produto = $this->produtoModel->getProdutoById($id);

            if ($produto) {

                // Incrementa a visualização do produto
                $this->produtoModel->incrementarVisualizacao($id);

                // Passa os dados para a view
                require_once 'app/views/header.php';
                require_once 'app/views/detalheProduto.php'; // Passa os dados para a view
                require_once 'app/views/footer.php';
            } else {
                // Se o produto não for encontrado
                http_response_code(404);
                require_once 'app/views/error.php';
            }
        } else {
            // Se o id não for fornecido na URL
            http_response_code(400); // Erro de solicitação inválida
            echo "ID do produto não fornecido.";
        }
    }
    
}
?>
