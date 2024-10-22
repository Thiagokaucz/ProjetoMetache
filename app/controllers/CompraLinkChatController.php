<?php

require_once 'app/models/CompraLinkChatModel.php';

class CompraLinkChatController {
    private $compraLinkChatModel;

    public function __construct() {
        $this->compraLinkChatModel = new CompraLinkChatModel();
    }

    public function mostrarDados() {
        $id = $_GET['id'] ?? null; // Captura o parâmetro 'id' da URL
        $produtoID = $_GET['produtoID'];

        if ($id) {
            // Busca os dados do link de compra e do produto
            $dados = $this->compraLinkChatModel->getDadosCompra($id, $produtoID);
            //var_dump($dados); // Adicione esta linha para depuração
            if ($dados) {
                
                // Busca o vendedorID usando o chatID
                $chatID = $dados['chatID']; // Acesse o chatID dos dados do link de compra
                $vendedorID = $this->compraLinkChatModel->getVendedorIDPorChatID($chatID);
                
                // Adiciona o vendedorID aos dados para passar para a view
                $dados['vendedorID'] = $vendedorID;
                // Chama a view e passa os dados
                require_once 'app/views/header.php';
                require 'app/views/CompraLinkChatView.php';
                require_once 'app/views/footer.php';
            } else {

                echo "Nenhum dado encontrado para o ID especificado.";
            }
        } else {
            echo "ID não especificado.";
        }
    }
}
