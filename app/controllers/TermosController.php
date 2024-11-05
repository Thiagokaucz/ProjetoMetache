<?php

class TermosController {
    public function mostrarTermos() {
        // Inicia a sessão caso seja necessário
        session_start();
        
        // Inclui a visualização dos Termos de Uso
        require 'app/views/TermosDeUso.php';
    }
}
