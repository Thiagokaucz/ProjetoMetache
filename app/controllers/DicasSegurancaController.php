<?php
session_start();

class DicasSegurancaController {

    public function index() {

        require_once 'app/views/header.php';
        require_once 'app/views/DicasSeguranca.php';
        require_once 'app/views/footerConfig.php';
    }

}