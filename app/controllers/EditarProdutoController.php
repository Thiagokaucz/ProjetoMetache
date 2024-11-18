<?php
require_once 'app/models/EditarProdutoModel.php';

class EditarProdutoController {
    private $editarProdutoModel;

    public function __construct() {
        $this->editarProdutoModel = new EditarProdutoModel();
    }

    public function editarProduto() {
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $produtoID = $_GET['id'] ?? null;

        $userID = $_SESSION['user_id'];

        if ($produtoID) {
            $produto = $this->editarProdutoModel->buscarProdutoPorID($produtoID);

            if ($produto && $produto['userID'] == $userID) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    $categoriaID = $_POST['categoriaID'];
                    $titulo = $_POST['titulo'];
                    $condicao = $_POST['condicao'];
                    $descricao = $_POST['descricao'];
                    $valor = $_POST['valor'];
                    $localizacao = $_POST['localizacao'];

                    $this->editarProdutoModel->atualizarProduto($produtoID, $titulo, $descricao, $valor);

                    header('Location: /meusAnuncios');
                    exit;
                }

                require_once 'app/views/header.php'; 
                require_once 'app/views/editarProduto.php';
                require_once 'app/views/footerConfig.php';
            } else {
                echo "Você não tem permissão para editar este produto.";
            }
        } else {
            echo "Produto não encontrado.";
        }
    }
}
?>
