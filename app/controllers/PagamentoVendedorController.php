<?php
session_start();
require_once 'app/models/PagamentoVendedorModel.php';

class PagamentoVendedorController {
    private $model;

    public function __construct() {
        $this->model = new PagamentoVendedorModel();
    }

    public function realizarPagamento() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if ($id) {
            $compra = $this->model->buscarCompraPorId($id);

            if ($compra) {
                $vendedorToken = $this->model->obterTokenVendedor($compra['vendedor_id']);
                if (!$vendedorToken) {
                    echo "Token do vendedor não encontrado.";
                    return;
                }

                $valorPagamento = $this->model->calcularValorPagamento($compra['valor_compra']);
                
                $preferenceData = [
                    "auto_return" => "approved",
                    "back_urls" => [
                        "success" => "https://abalonrpg.com/PosPagamento?id=" . $id,
                        "failure" => "http://httpbin.org/get?back_url=failure",
                        "pending" => "http://httpbin.org/get?back_url=pending"
                    ],
                    "items" => [
                        [
                            "title" => "Pagamento ao vendedor",
                            "quantity" => 1,
                            "unit_price" => floatval($valorPagamento)
                        ]
                    ],
                    "payer" => [
                        "email" => "test_user_12398378192@testuser.com"
                    ],
                    "payment_methods" => [
                        "excluded_payment_types" => [
                            ["id" => "credit_card"],
                            ["id" => "debit_card"],
                            ["id" => "ticket"],
                            ["id" => "bank_transfer"],
                            ["id" => "atm"]
                        ],
                        "default_payment_method_id" => "account_money",
                        "installments" => 1
                    ],
                    "notification_url" => "https://www.your-site.com/webhook"
                ];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.mercadopago.com/checkout/preferences',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($preferenceData),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $vendedorToken
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                $data = json_decode($response, true);

                if (isset($data['init_point'])) {
                    header("Location: " . $data['init_point']);
                    exit();
                } else {
                    echo "Erro ao criar a preferência de pagamento: " . $response;
                }

                $this->model->atualizarStatusPagamento($id, 'realizado');
            } else {
                echo "Compra não encontrada.";
            }
        } else {
            echo "ID da compra não especificado.";
        }
    }

public function atualizarStatusAdmMetache() {
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($id) {
        $this->model->atualizarStatusAdmMetache($id, 'finalizado');
        
        echo "
        <!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Status Atualizado</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body class='d-flex justify-content-center align-items-center bg-light' style='height: 100vh;'>
            <div class='container text-center'>
                <div class='alert alert-success' role='alert'>
                    <h4 class='alert-heading'>✅ Pagamento aprovado!</h4>
                    <p>O vendedor recebeu o pagamento.</p>
                    <p class='mb-0'>Redirecionando para a página de upload de documentos...</p>
                </div>
            </div>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
            <script>
                setTimeout(function() {
                    window.location.href = '/uploadDocumentos?compraspagamento={$id}';
                }, 3000);
            </script>
        </body>
        </html>
        ";
    } else {
        echo "ID da compra não especificado.";
    }
}

    
}
?>
