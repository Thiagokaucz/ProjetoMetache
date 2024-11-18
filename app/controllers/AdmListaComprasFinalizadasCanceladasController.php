<?php
session_start();

require_once 'app/models/ComprasFinalizadasCanceladasModel.php';

class AdmListaComprasFinalizadasCanceladasController {
    public function exibirComprasFinalizadasCanceladas() {
        $model = new ComprasFinalizadasCanceladasModel();
        $compras = $model->obterComprasFinalizadasCanceladas();
        
        include 'app/views/AdmHeader.php';
        include 'app/views/AdmListaComprasFinalizadasCanceladas.php';
    }
}
?>
