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
        $categoria = $_GET['Categoria'] ?? 'Todos'; // Padrão para 'Todos'
        $regiao = $_GET['Regiao'] ?? '';
        $pesquisa = $_GET['Pesquisa'] ?? '';
        $ordem = $_GET['Ordem'] ?? 'Data'; // Mudado para 'Ordem'
        
        // Realizando a busca
        $produtos = $this->produtosPesquisaModel->buscarProdutos($categoria, $regiao, $pesquisa);
    
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
        $totalProdutos = count($produtos);
    
        // Buscar categorias e regiões
        $categorias = $this->produtosPesquisaModel->obterCategorias();
        $regioes = $this->produtosPesquisaModel->obterRegioes();
    
        // Exibir os resultados
        require_once 'app/views/header.php';
        require 'app/views/ProdutosPesquisa.php';
    }
    
    
    
    
}
