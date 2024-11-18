<?php

session_start();
require_once 'app/models/VerificarCompraModel.php';

class VerificarCompraController {
    private $VerificarCompraModel;

    public function __construct() {
        $this->compraModel = new VerificarCompraModel();
    }

    public function processarCompra() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $collection_id = isset($_GET['collection_id']) ? htmlspecialchars($_GET['collection_id']) : 'ID não fornecido';
            $collection_status = isset($_GET['collection_status']) ? htmlspecialchars($_GET['collection_status']) : 'Status não fornecido';
            $payment_id = isset($_GET['payment_id']) ? htmlspecialchars($_GET['payment_id']) : 'ID do pagamento não fornecido';
            $status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : 'Status não fornecido';
            $external_reference = isset($_GET['external_reference']) ? htmlspecialchars($_GET['external_reference']) : 'Nenhuma referência externa';
            $payment_type = isset($_GET['payment_type']) ? htmlspecialchars($_GET['payment_type']) : 'Tipo de pagamento não fornecido';
            $merchant_order_id = isset($_GET['merchant_order_id']) ? htmlspecialchars($_GET['merchant_order_id']) : 'ID do pedido não fornecido';
            $preference_id = isset($_GET['preference_id']) ? htmlspecialchars($_GET['preference_id']) : 'ID da preferência não fornecido';
            $site_id = isset($_GET['site_id']) ? htmlspecialchars($_GET['site_id']) : 'ID do site não fornecido';
            $processing_mode = isset($_GET['processing_mode']) ? htmlspecialchars($_GET['processing_mode']) : 'Modo de processamento não fornecido';
            $merchant_account_id = isset($_GET['merchant_account_id']) ? htmlspecialchars($_GET['merchant_account_id']) : 'ID da conta do comerciante não fornecido';

            $linkCompraID = isset($_SESSION['linkCompraID']) ? $_SESSION['linkCompraID'] : 'Link de compra não definido';
            $produtoID = isset($_SESSION['produtoID']) ? $_SESSION['produtoID'] : 'Produto não definido';
            $chatID = isset($_SESSION['chatID']) ? $_SESSION['chatID'] : 'Chat não definido';
            $vendedorID = isset($_SESSION['vendedorID']) ? $_SESSION['vendedorID'] : 'Vendedor não definido';
            $valorBrutoCompra = isset($_SESSION['valorBrutoCompra']) ? $_SESSION['valorBrutoCompra'] : 0.0;
            $valorCompra = isset($_SESSION['valorCompra']) ? $_SESSION['valorCompra'] : 0.0;
            $valorFrete = isset($_SESSION['valorFrete']) ? $_SESSION['valorFrete'] : 0.0;

            if ($this->compraModel->inserirCompra($payment_id, $status, $linkCompraID, $produtoID, $chatID, $vendedorID, $valorBrutoCompra, $valorCompra, $valorFrete)) {
            } else {
                echo "Erro ao registrar a compra.";
            }

            unset($_SESSION['linkCompraID'], $_SESSION['produtoID'], $_SESSION['chatID'], $_SESSION['vendedorID'], $_SESSION['valorBrutoCompra'], $_SESSION['valorCompra'], $_SESSION['valorFrete']);

            echo '
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Processamento de Pagamento</title>
                <!-- Bootstrap CSS -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <!-- Bootstrap Icons -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
                <style>
                    .custom-progress-bar {
                        background-color: #FF6B01;
                    }
                    .custom-card {
                        background-color: #2E2E2E;
                        color: white;
                    }
                    .custom-text {
                        color: #FF6B01;
                    }
                    .spinner-border-custom {
                        color: #FF6B01;
                    }
                </style>
            </head>
            <body class="bg-light">
            <div class="container text-center mt-5">
                <div class="card shadow-lg p-4 custom-card">
                    <h3 class="custom-text mb-4"><i class="bi bi-credit-card"></i> Processando Pagamento...</h3>
                    <div class="progress my-4" style="height: 30px;">
                        <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated custom-progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div id="status-message" class="mt-3 fw-bold text-white"></div>
                    <div class="spinner-border spinner-border-custom mt-3" role="status" aria-hidden="true"></div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                const messages = [
                    "<i class=\'bi bi-hourglass-split\'></i> Realizando pagamento...",
                    "<i class=\'bi bi-clock-history\'></i> O produto já é quase seu...",
                    "<i class=\'bi bi-check-circle\'></i> Pagamento concluído!"
                ];
                const progressBar = document.getElementById("progress-bar");
                const statusMessage = document.getElementById("status-message");
                let progress = 0;
                let messageIndex = 0;

                function updateProgress() {
                    if (progress < 100) {
                        progress += 1;
                        progressBar.style.width = progress + "%";
                        progressBar.setAttribute("aria-valuenow", progress);
                        if (progress % 33 === 0 && messageIndex < messages.length) {
                            statusMessage.innerHTML = messages[messageIndex];
                            messageIndex++;
                        }
                    } else {
                        clearInterval(interval);
                        window.location.href = "/finalizarCompra?linkCompraID=' . urlencode($linkCompraID) . 
                                                      '&produtoID=' . urlencode($produtoID) . 
                                                      '&chatID=' . urlencode($chatID) . 
                                                      '&vendedorID=' . urlencode($vendedorID) . 
                                                      '&valorBrutoCompra=' . urlencode($valorBrutoCompra) . 
                                                      '&valorCompra=' . urlencode($valorCompra) . 
                                                      '&valorFrete=' . urlencode($valorFrete) . '";
                    }
                }

                const interval = setInterval(updateProgress, 100);
            </script>
            </body>
            </html>';
        } else {
            echo "Método de requisição inválido.";
        }
    }
}
?>
