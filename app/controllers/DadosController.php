<?php
// controllers/DadosController.php

class DadosController {
    public function linkPage() {
        // Carrega a view com o link para autorização no Mercado Pago
        include 'app/views/linkView.php';
    }

    public function showData() {
        // Verifica se o parâmetro 'code' está na URL (token de autorização)
        if (isset($_GET['code'])) {
            // Captura o código de autorização
            $authorizationCode = $_GET['code'];

            // Armazena o token em um array de dados para exibição
            $dados = [
                'codigo_autorizacao' => $authorizationCode
            ];
        } else {
            $dados = [
                'erro' => 'Nenhum código de autorização encontrado.'
            ];
        }

        // Chama a view para exibir o código de autorização ou erro
        include 'app/views/dadosView.php';
    }
}
?>
