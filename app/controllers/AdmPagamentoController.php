<?php

session_start();

require_once 'app/models/AdmPagamentoModel.php';

class AdmPagamentoController {
    private $model;

    public function __construct() {
        $this->model = new AdmPagamentoModel(); 
    }

    public function mostrarPagamento() {
        $id = $_GET['id'] ?? null;
        $detalhes = $this->model->getPagamentoDetails($id);

        if ($detalhes) {
            include 'app/views/AdmHeader.php';
            require 'app/views/Admpagamento.php';
        } else {
            echo "Nenhum pagamento encontrado.";
        }
    }

    public function pagar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $atualizado = $this->model->finalizarPagamento($id);
            if ($atualizado) {
                header('Location: /admPagamentos'); 
            } else {
                echo "Erro ao atualizar o pagamento.";
            }
        } else {
            echo "ID do pagamento não fornecido.";
        }
    }
    
    public function atualizarStatusDenuncia() {
        $aquisicaoID = $_POST['aquisicaoID'] ?? null;
        $novoStatus = $_POST['novoStatus'] ?? null;
        $pagamentoID = $_POST['pagamentoID'] ?? null;
    
        if ($aquisicaoID && $novoStatus && $pagamentoID) {
            $this->model->atualizarStatusDenuncia($aquisicaoID, $novoStatus);
            
            header("Location: /PagamentoAdm?id=" . $pagamentoID);
            exit;
        } else {
            echo "Dados insuficientes para atualizar o status da denúncia.";
        }
    }
    
}
?>