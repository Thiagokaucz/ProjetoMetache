<?php
require_once 'app/models/AdmPagamentoModel.php';

class AdmPagamentoController {
    private $model;

    public function __construct() {
        $this->model = new PagamentoModel();
    }

    public function mostrarPagamento() {
        $id = $_GET['id'] ?? null;
        $detalhes = $this->model->getPagamentoDetails($id);

        if ($detalhes) {
            // Passa os detalhes para a view
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
                // Redireciona ou mostra mensagem de sucesso
                header('Location: /admPagamentos');
            } else {
                echo "Erro ao atualizar o pagamento.";
            }
        } else {
            echo "ID do pagamento não fornecido.";
        }
    }
}
