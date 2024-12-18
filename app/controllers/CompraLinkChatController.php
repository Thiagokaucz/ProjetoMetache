<?php
session_start();

require_once 'app/models/CompraLinkChatModel.php';

class CompraLinkChatController {
    private $compraLinkChatModel;

    public function __construct() {
        $this->compraLinkChatModel = new CompraLinkChatModel();
    }

    public function mostrarDados() {
        $id = $_GET['id'] ?? null;
        $produtoID = $_GET['produtoID'];

        if ($id) {
            $this->compraLinkChatModel->marcarComoVisualizado($id);

            $dados = $this->compraLinkChatModel->getDadosCompra($id, $produtoID);

            if ($dados) {
                $chatID = $dados['chatID'];
                $vendedorID = $this->compraLinkChatModel->getVendedorIDPorChatID($chatID);

                $dados['vendedorID'] = $vendedorID;
                require_once 'app/views/header.php';
                require 'app/views/CompraLinkChatView.php';
            } else {
                echo "Nenhum dado encontrado para o ID especificado.";
            }
        } else {
            echo "ID não especificado.";
        }
    }
}
