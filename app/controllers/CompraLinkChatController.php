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
                // Chama a view e passa os dados
                require 'app/views/CompraLinkChatView.php';
            } else {

                echo "Nenhum dado encontrado para o ID especificado.";
            }
        } else {
            echo "ID não especificado.";
        }
    }
}
