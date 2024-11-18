<?php

require_once 'app/models/AnunciarProdutoModel.php';

session_start();

class AnunciarProdutoController {

    public function __construct() {
        $produtoModel = new AnunciarProdutoModel();
    }

public function index() {
    if (isset($_SESSION['user_id'])) { 
        $userID = $_SESSION['user_id'];
        $produtoModel = new AnunciarProdutoModel();

        if (!$produtoModel->verificarVendedor($userID)) {

            require_once 'app/views/header.php';
            require_once 'app/views/PedidoVincularContaMercadoPago.php';
            require_once 'app/views/footerConfig.php';

            return; 
        }

        $categorias = $produtoModel->getCategorias();  

        require_once 'app/views/header.php';
        require_once 'app/views/anunciarProduto.php';  
        require_once 'app/views/footerConfig.php';

    } else {
        header("Location: /login");
    }
}


    
   public function criarProduto() {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $errors = [];
            $userID = $_SESSION['user_id'];
            $titulo = trim($_POST['titulo']);
            $marca = trim($_POST['marca']);
            $descricao = trim($_POST['descricao']);
            $valor = trim($_POST['valor']);
            $localizacao = trim($_POST['localizacao']);
            $categoriaID = $_POST['categoria'];
            $condicao = $_POST['condicao'];

            $produtoModel = new AnunciarProdutoModel();

            if (!$produtoModel->verificarUsuarioExiste($userID)) {
                $errors[] = 'Usuário não encontrado.';
            }

            if (!$produtoModel->verificarCategoriaExiste($categoriaID)) {
                $errors[] = 'Categoria não encontrada.';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: /anunciarProduto");
                exit;
            }

            if ($produtoModel->criarProduto($_POST, $_FILES, $userID)) {

                header("Location: /meusAnuncios");
                exit;
            } else {

                require_once 'app/views/error.php';
            }
        } else {
            $this->index();
        }
    }

    private function uploadFotos($files, $userID) {
        $targetDir = "uploads/";

        $userDir = $targetDir . $userID . '/';
        if (!file_exists($userDir)) {
            mkdir($userDir, 0777, true); 
        }

        $fileNames = [];

        foreach ($files['name'] as $key => $name) {

            $uniqueName = strtoupper(bin2hex(random_bytes(16))) . '.' . pathinfo($name, PATHINFO_EXTENSION);

            $targetFile = $userDir . $uniqueName;

            if (move_uploaded_file($files['tmp_name'][$key], $targetFile)) {

                $fileNames[] = $targetFile;
            }
        }

        return implode(',', $fileNames);
    }

}
?>