<?php
require_once 'app/models/EditarProdutoModel.php';

class EditarProdutoController {
    private $editarProdutoModel;

    public function __construct() {
        $this->editarProdutoModel = new EditarProdutoModel();
    }

    public function editarProduto() {
        session_start();
        
        // Verifica se o usuário está logado
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Obtém o ID do produto a partir da URL
        $produtoID = $_GET['id'] ?? null;

        // Obtém o ID do usuário logado
        $userID = $_SESSION['user_id'];

        if ($produtoID) {
            // Busca o produto no banco de dados
            $produto = $this->editarProdutoModel->buscarProdutoPorID($produtoID);

            // Verifica se o produto pertence ao usuário logado
            if ($produto && $produto['userID'] == $userID) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Obtém os dados do formulário
                    $categoriaID = $_POST['categoriaID'];
                    $titulo = $_POST['titulo'];
                    $condicao = $_POST['condicao'];
                    $descricao = $_POST['descricao'];
                    $valor = $_POST['valor'];
                    $localizacao = $_POST['localizacao'];

                    // Atualiza o produto no banco de dados
                    $this->editarProdutoModel->atualizarProduto($produtoID, $categoriaID, $titulo, $condicao, $descricao, $valor, $localizacao);

                    // Redireciona após a edição
                    header('Location: /meusAnuncios');
                    exit;
                }

                // Exibe a view de edição com os dados do produto
                require_once 'app/views/header.php'; // Carregar cabeçalho
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
