<?php

class DadosController {
    public function linkPage() {
        include 'app/views/linkView.php';
    }

    public function showData() {
        if (isset($_GET['code'])) {
            $authorizationCode = $_GET['code'];

            $dados = [
                'codigo_autorizacao' => $authorizationCode
            ];
        } else {
            $dados = [
                'erro' => 'Nenhum código de autorização encontrado.'
            ];
        }

        include 'app/views/dadosView.php';
    }
}
?>
