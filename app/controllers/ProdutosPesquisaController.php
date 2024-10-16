<?php
require_once 'app/models/ProdutosPesquisaModel.php';

class ProdutosPesquisaController {
    private $produtosPesquisaModel;

    public function __construct() {
        $this->produtosPesquisaModel = new ProdutosPesquisaModel();
    }    

    public function pesquisarProdutos() {
        // Pegando os parâmetros da URL
        $categoria = $_GET['Categoria'] ?? '';
        $regiao = $_GET['Regiao'] ?? '';
        $pesquisa = $_GET['Pesquisa'] ?? '';
        $ordem = $_GET['ordem'] ?? 'data'; // Padrão de ordem por data
    
        // Realizando a busca
        $produtos = $this->produtosPesquisaModel->buscarProdutos($categoria, $regiao, $pesquisa);
    
        // Ordenar os produtos com base na opção escolhida
        if ($ordem === 'preco') {
            usort($produtos, function($a, $b) {
                return $a['valor'] <=> $b['valor'];
            });
        } elseif ($ordem === 'data') {
            usort($produtos, function($a, $b) {
                return strtotime($b['dataHoraPub']) <=> strtotime($a['dataHoraPub']);
            });
        }
    
        // Contar o total de produtos encontrados
        $totalProdutos = count($produtos);
    
        // Buscar categorias e regiões
        $categorias = $this->produtosPesquisaModel->obterCategorias(); // Método para obter todas as categorias
        $regioes = $this->produtosPesquisaModel->obterRegioes(); // Método para obter todas as regiões
    
        // Exibir os resultados
        require 'app/views/ProdutosPesquisa.php';
    }
    
    
}
