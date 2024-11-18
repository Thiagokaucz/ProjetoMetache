<?php

class NaoPodeComprarProdutoController {
    public function index() {
        session_start();
        
        require_once 'app/views/header.php';
        require_once 'app/views/NaoPodeComprarProduto.php'; 
        require_once 'app/views/footerConfig.php';
    }
}
