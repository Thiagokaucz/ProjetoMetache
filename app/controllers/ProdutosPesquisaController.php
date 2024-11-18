<?php
require_once 'app/models/ProdutosPesquisaModel.php';
session_start();

class ProdutosPesquisaController {
    private $produtosPesquisaModel;

    public function __construct() {
        $this->produtosPesquisaModel = new ProdutosPesquisaModel();
    }

    public function pesquisarProdutos() {
        $categoria = $_GET['Categoria'] ?? 'Todos';
        $regiao = $_GET['Regiao'] ?? '';
        $pesquisa = $_GET['Pesquisa'] ?? '';
        $ordem = $_GET['Ordem'] ?? 'Data';

        $paginaAtual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limitePorPagina = 10;
        $offset = ($paginaAtual - 1) * $limitePorPagina;

        $produtos = $this->produtosPesquisaModel->buscarProdutos($categoria, $regiao, $pesquisa, $offset, $limitePorPagina);

        if ($ordem === 'Preco') {
            usort($produtos, function($a, $b) {
                return $a['valor'] <=> $b['valor'];
            });
        } elseif ($ordem === 'Data') {
            usort($produtos, function($a, $b) {
                return strtotime($b['dataHoraPub']) <=> strtotime($a['dataHoraPub']);
            });
        }

        $totalProdutos = $this->produtosPesquisaModel->contarProdutos($categoria, $regiao, $pesquisa);

        $totalPaginas = ceil($totalProdutos / $limitePorPagina);

        $categorias = $this->produtosPesquisaModel->obterCategorias();
        $regioes = $this->produtosPesquisaModel->obterRegioes();

        require_once 'app/views/header.php';
        require 'app/views/ProdutosPesquisa.php';
    }
}

