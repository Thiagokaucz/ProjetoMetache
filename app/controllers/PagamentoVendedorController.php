<?php
session_start();
require_once 'app/models/PagamentoVendedorModel.php';

class PagamentoVendedorController {
    private $model;

    public function __construct() {
        $this->model = new PagamentoVendedorModel();
    }

    public function realizarPagamento() {
        // Verifica se o ID da compra foi passado na URL
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if ($id) {
            // Busca os detalhes da compra pelo ID
            $compra = $this->model->buscarCompraPorId($id);

            if ($compra) {
                // Busca o token do vendedor
                $vendedorToken = $this->model->obterTokenVendedor($compra['vendedor_id']);
                if (!$vendedorToken) {
                    echo "Token do vendedor não encontrado.";
                    return;
                }

                // Calcula o valor a ser transferido para o vendedor (5% do valor da compra)
                $valorPagamento = $this->model->calcularValorPagamento($compra['valor_compra']);
                
                // Configurando a preferência de pagamento para o Mercado Pago
                $preferenceData = [
                    "auto_return" => "approved",
                    "back_urls" => [
                        "success" => "http://localhost/VerificarPagamentoController",
                        "failure" => "http://httpbin.org/get?back_url=failure",
                        "pending" => "http://httpbin.org/get?back_url=pending"
                    ],
                    "items" => [
                        [
                            "title" => "Pagamento ao vendedor",
                            "quantity" => 1,
                            "unit_price" => floatval($valorPagamento)  // Valor a ser transferido para o vendedor
                        ]
                    ],
                    "payer" => [
                        "email" => "test_user_12398378192@testuser.com"  // E-mail do destinatário, pode ser alterado para o e-mail real
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
                        "installments" => 1  // Número de parcelas permitidas
                    ],
                    "notification_url" => "https://www.your-site.com/webhook"  // URL para notificações
                ];

                // Inicializando cURL para o Mercado Pago
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
                    // Em caso de erro, exibe a mensagem ou loga o erro
                    echo "Erro ao criar a preferência de pagamento: " . $response;
                }

                // Atualiza o status do pagamento para "realizado"
                $this->model->atualizarStatusPagamento($id, 'realizado');
            } else {
                echo "Compra não encontrada.";
            }
        } else {
            echo "ID da compra não especificado.";
        }
    }
}
?>
