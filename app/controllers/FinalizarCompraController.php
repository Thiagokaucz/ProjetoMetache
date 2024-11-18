<?php
session_start();

require_once 'app/models/FinalizarCompraModel.php';

class FinalizarCompraController {
    private $finalizarCompraModel;

    public function __construct() {
        $this->finalizarCompraModel = new FinalizarCompraModel();
    }

    public function processar() {
        $linkCompraID = $_GET['linkCompraID'] ?? null;
        $produtoID = $_GET['produtoID'] ?? null;
        $chatID = $_GET['chatID'] ?? null;
        $vendedorID = $_GET['vendedorID'] ?? null;
        
        $valorBrutoCompra = $_GET['valorBrutoCompra'] ?? null;
        $valorCompra = $_GET['valorCompra'] ?? null;
        $valorFrete = $_GET['valorFrete'] ?? null;

        $compradorID = $_SESSION['user_id'] ?? null;

        if ($produtoID && $chatID && $compradorID && $vendedorID && $valorBrutoCompra && $valorCompra && $valorFrete) {
            if ($this->finalizarCompraModel->finalizarCompra($produtoID, $chatID, $compradorID, $vendedorID, $valorCompra, $valorFrete)) {
                if ($this->finalizarCompraModel->atualizarAquisicaoIDPorProduto($produtoID)) {
                    echo '
                    <!DOCTYPE html>
                    <html lang="pt-br">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Compra Realizada</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    </head>
                    <body class="d-flex justify-content-center align-items-center bg-light" style="height: 100vh;">
                        <div class="container text-center">
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">✅ Compra realizada com sucesso!</h4>
                                <p class="mb-0">A aquisição foi aprovada.</p>
                            </div>
                        </div>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                        <script>
                            setTimeout(function() {
                                window.location.href = "/minhasCompras";
                            }, 5000);
                        </script>
                    </body>
                    </html>';
                } else {
                    echo '
                    <div class="container text-center mt-5">
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">✅ Compra realizada, mas houve um erro ao atualizar o aquisicaoID.</h4>
                        </div>
                    </div>';
                }
            } else {
                echo "Erro ao realizar a compra. Tente novamente.";
            }
        } else {
            echo "Parâmetros inválidos. Verifique os dados fornecidos.";
        }
    }
}
?>
