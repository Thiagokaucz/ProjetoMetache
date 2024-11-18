<?php
session_start();

class AjudaContatoController {

    public function index() {

        require_once 'app/views/header.php';
        require_once 'app/views/AjudaContato.php';
        require_once 'app/views/footerConfig.php';
    }

}