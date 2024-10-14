<?php

require_once 'app/models/AnunciarProdutoModel.php';

session_start();

class AnunciarProdutoController {

    public function __construct() {
        $produtoModel = new AnunciarProdutoModel();
    }

    // Exibe o formulário de anúncio
    public function index() {
        require_once 'app/views/header.php';
        
        // Criação da instância do modelo de produtos
        $produtoModel = new AnunciarProdutoModel();
        $categorias = $produtoModel->getCategorias();  // Aqui você busca as categorias diretamente do modelo de produtos

        // Passando as categorias para a view
        require_once 'app/views/anunciarProduto.php';  
        require_once 'app/views/footer.php';
    }
    
   // Cria o anúncio do produto
   public function criarProduto() {
        // Verifica se os dados do formulário foram enviados
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Validação dos dados do formulário
            $errors = [];
            $userID = $_SESSION['user_id'];
            $titulo = trim($_POST['titulo']);
            $marca = trim($_POST['marca']);
            $descricao = trim($_POST['descricao']);
            $valor = trim($_POST['valor']);
            $localizacao = trim($_POST['localizacao']);
            $categoriaID = $_POST['categoria'];
            $condicao = $_POST['condicao'];

            // Criação da instância do model de produtos
            $produtoModel = new AnunciarProdutoModel();

            // Verifica se o userID existe
            if (!$produtoModel->verificarUsuarioExiste($userID)) {
                $errors[] = 'Usuário não encontrado.';
            }

            // Verifica se o categoriaID existe
            if (!$produtoModel->verificarCategoriaExiste($categoriaID)) {
                $errors[] = 'Categoria não encontrada.';
            }

            // Se houver erros, exibe-os
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: /anunciarProduto");
                exit;
            }

            // Chama a função do modelo para criar o produto e faz o upload das fotos
            if ($produtoModel->criarProduto($_POST, $_FILES, $userID)) {
                // Redireciona para a página de sucesso ou lista de produtos
                header("Location: /produtos");
                exit;
            } else {
                // Caso ocorra um erro, mostra uma página de erro
                require_once 'app/views/error.php';
            }
        } else {
            // Se o método não for POST, redireciona para o formulário
            $this->index();
        }
    }

    // Função para upload das fotos (pode ser movida para uma classe de utilidade)
    private function uploadFotos($files, $userID) {
        // Diretório principal de upload
        $targetDir = "uploads/";

        // Cria a pasta do usuário, se não existir
        $userDir = $targetDir . $userID . '/';
        if (!file_exists($userDir)) {
            mkdir($userDir, 0777, true); // Cria a pasta com permissões 0777
        }

        // Array para armazenar os caminhos das imagens
        $fileNames = [];

        // Itera sobre os arquivos para realizar o upload
        foreach ($files['name'] as $key => $name) {
            // Gera um nome único para o arquivo usando UUID
            $uniqueName = strtoupper(bin2hex(random_bytes(16))) . '.' . pathinfo($name, PATHINFO_EXTENSION);

            // Caminho completo para salvar o arquivo
            $targetFile = $userDir . $uniqueName;

            // Move o arquivo para o diretório de uploads do usuário
            if (move_uploaded_file($files['tmp_name'][$key], $targetFile)) {
                // Adiciona o caminho relativo do arquivo ao array
                $fileNames[] = $targetFile;
            }
        }

        // Retorna o caminho completo das imagens, separado por vírgula
        return implode(',', $fileNames);
    }

}
?>