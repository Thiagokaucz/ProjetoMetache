<?php
require_once 'app/models/ProdutosPesquisaModel.php';
session_start();

class ProdutosPesquisaController {
    private $produtosPesquisaModel;

    public function __construct() {
        $this->produtosPesquisaModel = new ProdutosPesquisaModel();
    }

    public function pesquisarProdutos() {
        // Pegando os parâmetros da URL
        $categoria = $_GET['Categoria'] ?? 'Todos';
        $regiao = $_GET['Regiao'] ?? '';
        $pesquisa = $_GET['Pesquisa'] ?? '';
        $ordem = $_GET['Ordem'] ?? 'Data';

        // Página atual e limite de produtos por página
        $paginaAtual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limitePorPagina = 10;
        $offset = ($paginaAtual - 1) * $limitePorPagina;

        // Buscar produtos com base nos filtros e na paginação
        $produtos = $this->produtosPesquisaModel->buscarProdutos($categoria, $regiao, $pesquisa, $offset, $limitePorPagina);

        // Ordenar os produtos com base na opção escolhida
        if ($ordem === 'Preco') {
            usort($produtos, function($a, $b) {
                return $a['valor'] <=> $b['valor'];
            });
        } elseif ($ordem === 'Data') {
            usort($produtos, function($a, $b) {
                return strtotime($b['dataHoraPub']) <=> strtotime($a['dataHoraPub']);
            });
        }

        // Contar o total de produtos encontrados
        $totalProdutos = $this->produtosPesquisaModel->contarProdutos($categoria, $regiao, $pesquisa);

        // Calcular o total de páginas
        $totalPaginas = ceil($totalProdutos / $limitePorPagina);

        // Buscar categorias e regiões
        $categorias = $this->produtosPesquisaModel->obterCategorias();
        $regioes = $this->produtosPesquisaModel->obterRegioes();

        // Exibir os resultados
        require_once 'app/views/header.php';
        require 'app/views/ProdutosPesquisa.php';
    }
}

