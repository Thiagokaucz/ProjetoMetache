<?php
session_start();
require_once 'app/models/TratarCompraModel.php';

class TratarCompraController {
    private $tratarCompraModel;

    public function __construct() {
        $this->tratarCompraModel = new TratarCompraModel();
    }

    public function processarCompra() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Capturando dados do formulário
            $linkCompraID = isset($_POST['linkCompraID']) ? htmlspecialchars($_POST['linkCompraID']) : null;
            $produtoID = isset($_POST['produtoID']) ? htmlspecialchars($_POST['produtoID']) : null;
            $chatID = isset($_POST['chatID']) ? htmlspecialchars($_POST['chatID']) : null;
            $vendedorID = isset($_POST['vendedorID']) ? htmlspecialchars($_POST['vendedorID']) : null;
            $valorBrutoCompra = isset($_POST['valorBrutoCompra']) ? htmlspecialchars($_POST['valorBrutoCompra']) : null;
            $valorCompra = isset($_POST['valorCompra']) ? htmlspecialchars($_POST['valorCompra']) : null;
            $valorFrete = isset($_POST['valorFrete']) ? htmlspecialchars($_POST['valorFrete']) : null;

            // Verifica se o userID está definido na sessão
            $userID = isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : 'Usuário não logado';
            $acao = isset($_POST['acao']) ? htmlspecialchars($_POST['acao']) : null;

            // Se a ação é de comprar, cria a preferência de pagamento
            if ($acao === 'comprar') {
                // Enviando mensagem para o vendedor antes de criar a preferência de pagamento
                $conteudo = "<b>Metache informa</b>: O link de pagamento foi utilizado. Obrigado por escolher nossa plataforma!";
                $this->tratarCompraModel->enviarMensagemParaVendedor($conteudo, $vendedorID, $chatID);

                // Criando a preferência de pagamento no Mercado Pago
                $this->criarPreferenciaPagamento($linkCompraID, $produtoID, $chatID, $vendedorID, $valorBrutoCompra, $valorCompra, $valorFrete);
            }
        } else {
            echo "Método de requisição inválido.";
        }
    }

    private function criarPreferenciaPagamento($linkCompraID, $produtoID, $chatID, $vendedorID, $valorBrutoCompra, $valorCompra, $valorFrete) {
        $_SESSION['linkCompraID'] = $linkCompraID;
        $_SESSION['produtoID'] = $produtoID;
        $_SESSION['chatID'] = $chatID;
        $_SESSION['vendedorID'] = $vendedorID;
        $_SESSION['valorBrutoCompra'] = $valorBrutoCompra;
        $_SESSION['valorCompra'] = $valorCompra;
        $_SESSION['valorFrete'] = $valorFrete;

        // Configurando a preferência de pagamento
        $preferenceData = [
            "auto_return" => "approved",
            "back_urls" => [
                "success" => "https://abalonrpg.com/VerificarCompraController",
                "failure" => "http://httpbin.org/get?back_url=failure",
                "pending" => "http://httpbin.org/get?back_url=pending"
            ],
            "statement_descriptor" => "TestStore",
            "items" => [
                [
                    "title" => "Produto ID: " . htmlspecialchars($produtoID),
                    "quantity" => 1,
                    "unit_price" => floatval($valorCompra),
                    "description" => "Descrição do produto",
                    "category_id" => "retail"
                ]
            ],
            "payer" => [
                "email" => "test_user_12398378192@testuser.com",
                "name" => "Juan",
                "surname" => "Lopez",
                "phone" => [
                    "area_code" => "11",
                    "number" => "1523164589"
                ],
                "identification" => [
                    "type" => "DNI",
                    "number" => "12345678"
                ],
                "address" => [
                    "street_name" => "Rua",
                    "street_number" => 123,
                    "zip_code" => "1406"
                ]
            ],
            "payment_methods" => [
                "excluded_payment_types" => [],
                "excluded_payment_methods" => [],
                "installments" => 1,
                "default_payment_method_id" => "account_money"
            ],
            "notification_url" => "https://www.your-site.com/webhook",
            "expires" => true,
            "expiration_date_from" => "2024-01-01T12:00:00.000-04:00",
            "expiration_date_to" => "2024-12-31T12:00:00.000-04:00"
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/checkout/preferences',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($preferenceData),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer APP_USR-2443018850634328-110519-d3375444bdfd492d622f7b85def636b0-2080748602' // Token Metache
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
    }
}
?>
