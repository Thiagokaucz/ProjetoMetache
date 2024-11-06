<?php

session_start();

require_once 'app/models/AdmCancelarCompraModel.php';

class AdmCancelarCompraController {
    private $model;

    public function __construct() {
        $this->model = new AdmCancelarCompraModel();
    }

    public function cancelarCompra() {
        $aquisicaoID = $_GET['id'] ?? null;

        if ($aquisicaoID) {
            // Executa a operação de cancelamento e obtém os dados do comprador
            $comprador = $this->model->cancelarCompra($aquisicaoID);

            if ($comprador) {
                include 'app/views/AdmHeader.php';
                include 'app/views/AdmCancelarCompraSucesso.php';
            } else {
                echo "Erro ao cancelar a compra.";
            }
        } else {
            echo "ID da aquisição não fornecido.";
        }
    }
}
?>
