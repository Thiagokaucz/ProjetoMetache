<?php
session_start();

class SobrePlataformaController {
    public function exibirInformacoes() {
        $section = isset($_GET['section']) ? $_GET['section'] : 'resumo';

        require_once 'app/views/header.php';
        require 'app/views/SobrePlataforma.php';
        require_once 'app/views/footerConfig.php';
    }
}
