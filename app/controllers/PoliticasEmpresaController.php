<?php

class PoliticasEmpresaController {
    public function index() {
        // Inicia a sessão caso seja necessário
        session_start();
        
        require_once 'app/views/header.php';
        require_once 'app/views/PoliticasEmpresa.php'; 
    }
}
