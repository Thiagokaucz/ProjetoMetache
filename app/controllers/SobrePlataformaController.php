<?php
session_start();

class SobrePlataformaController {
    public function exibirInformacoes() {
        // Obtém o valor da seção da URL (exemplo: `/sobre?section=compra`)
        $section = isset($_GET['section']) ? $_GET['section'] : 'resumo';

        // Redireciona para a view passando a seção solicitada
        require_once 'app/views/header.php';
        require 'app/views/SobrePlataforma.php';
        require_once 'app/views/footerConfig.php';
    }
}
