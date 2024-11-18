<?php

class PoliticasEmpresaController {
    public function index() {
        session_start();
        
        require_once 'app/views/header.php';
        require_once 'app/views/PoliticasEmpresa.php'; 
    }
}
