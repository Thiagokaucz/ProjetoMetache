<?php

session_start();

require_once 'app/models/AdmListaComprasModel.php';

class AdmListaComprasController {
    public function exibirComprasPendentes() {
        $model = new ComprasPagamentoModel();
        $compras = $model->obterComprasPendentes();
        
        // Carregar a view e passar os dados
        include 'app/views/AdmHeader.php';
        include 'app/views/AdmListaCompras.php';
    }
}
?>
