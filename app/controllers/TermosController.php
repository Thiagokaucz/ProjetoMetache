<?php

class TermosController {
    public function mostrarTermos() {
        session_start();
        
        require 'app/views/TermosDeUso.php';
    }
}
