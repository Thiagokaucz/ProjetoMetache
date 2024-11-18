<?php

session_start();

require_once 'app/models/AdmListaComprasModel.php';

class AdmListaComprasController {
    public function exibirComprasPendentes() {
        $model = new ComprasPagamentoModel();
        $compras = $model->obterComprasPendentes();
        
        include 'app/views/AdmHeader.php';
        include 'app/views/AdmListaCompras.php';
    }
}
?>