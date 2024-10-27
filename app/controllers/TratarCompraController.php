<?php
session_start(); 

class TratarCompraController {
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
                "success" => "http://localhost/VerificarCompraController",
                "failure" => "http://httpbin.org/get?back_url=failure",
                "pending" => "http://httpbin.org/get?back_url=pending"
            ],
            "statement_descriptor" => "TestStore",
            "items" => [
                [
                    "title" => "Produto ID: " . htmlspecialchars($produtoID),
                    "quantity" => 1,
                    "unit_price" => floatval($valorCompra),  // valor da compra
                    "description" => "Descrição do produto",
                    "category_id" => "retail"
                ]
            ],
            "payer" => [
                "email" => "test_user_12398378192@testuser.com",  // Exemplo, mude para o e-mail do comprador
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

        // Inicializando cURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/checkout/preferences',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($preferenceData),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer APP_USR-6871026775986460-102711-1b8ea71b2ccf41789390b2995d9bae18-1837410674' // Substitua pelo seu token
            ),
        ));

        // Executando a requisição
        $response = curl_exec($curl);
        curl_close($curl);

        // Decodificando a resposta
        $data = json_decode($response, true);

        // Verificando se a URL do checkout está presente
        if (isset($data['init_point'])) {
            // Redireciona o usuário para a URL do checkout
            header("Location: " . $data['init_point']);
            exit();
        } else {
            // Se houver erro, você pode exibir uma mensagem ou logar o erro
            echo "Erro ao criar a preferência de pagamento: " . $response;
        }
    }
}

?>
