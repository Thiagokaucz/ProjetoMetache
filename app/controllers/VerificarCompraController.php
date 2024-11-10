<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'app/models/VerificarCompraModel.php'; // Inclua o model de compra

class VerificarCompraController {
    private $VerificarCompraModel;

    public function __construct() {
        $this->compraModel = new VerificarCompraModel(); // Inicializa o model
    }

    public function processarCompra() {
        // Verifica se a requisição é do tipo GET
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Capturando os dados da URL
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

            // Verifica se os dados da sessão estão disponíveis
            $linkCompraID = isset($_SESSION['linkCompraID']) ? $_SESSION['linkCompraID'] : 'Link de compra não definido';
            $produtoID = isset($_SESSION['produtoID']) ? $_SESSION['produtoID'] : 'Produto não definido';
            $chatID = isset($_SESSION['chatID']) ? $_SESSION['chatID'] : 'Chat não definido';
            $vendedorID = isset($_SESSION['vendedorID']) ? $_SESSION['vendedorID'] : 'Vendedor não definido';
            $valorBrutoCompra = isset($_SESSION['valorBrutoCompra']) ? $_SESSION['valorBrutoCompra'] : 0.0;
            $valorCompra = isset($_SESSION['valorCompra']) ? $_SESSION['valorCompra'] : 0.0;
            $valorFrete = isset($_SESSION['valorFrete']) ? $_SESSION['valorFrete'] : 0.0;

            // Inserindo os dados no banco de dados
            if ($this->compraModel->inserirCompra($payment_id, $status, $linkCompraID, $produtoID, $chatID, $vendedorID, $valorBrutoCompra, $valorCompra, $valorFrete)) {
                echo "Compra registrada com sucesso!";
            } else {
                echo "Erro ao registrar a compra.";
            }

            // Exibindo os detalhes da transação
            echo "<h2>Detalhes da Transação</h2>";
            echo "<strong>Collection ID:</strong> $collection_id<br>";
            echo "<strong>Collection Status:</strong> $collection_status<br>";
            echo "<strong>Payment ID:</strong> $payment_id<br>";
            echo "<strong>Status:</strong> $status<br>";
            echo "<strong>External Reference:</strong> $external_reference<br>";
            echo "<strong>Payment Type:</strong> $payment_type<br>";
            echo "<strong>Merchant Order ID:</strong> $merchant_order_id<br>";
            echo "<strong>Preference ID:</strong> $preference_id<br>";
            echo "<strong>Site ID:</strong> $site_id<br>";
            echo "<strong>Processing Mode:</strong> $processing_mode<br>";
            echo "<strong>Merchant Account ID:</strong> $merchant_account_id<br>";

            // Exibindo informações adicionais da compra (opcional)
            echo "<h3>Informações da Compra</h3>";
            echo "<strong>Link de Compra ID:</strong> $linkCompraID<br>";
            echo "<strong>Produto ID:</strong> $produtoID<br>";
            echo "<strong>Chat ID:</strong> $chatID<br>";
            echo "<strong>Vendedor ID:</strong> $vendedorID<br>";
            echo "<strong>Valor Bruto da Compra:</strong> $valorBrutoCompra<br>";
            echo "<strong>Valor da Compra:</strong> $valorCompra<br>";
            echo "<strong>Valor do Frete:</strong> $valorFrete<br>";

            // Limpando as variáveis da sessão
            unset($_SESSION['linkCompraID']);
            unset($_SESSION['produtoID']);
            unset($_SESSION['chatID']);
            unset($_SESSION['vendedorID']);
            unset($_SESSION['valorBrutoCompra']);
            unset($_SESSION['valorCompra']);
            unset($_SESSION['valorFrete']);
        } else {
            echo "Método de requisição inválido.";
        }

        // Processa a aprovação
        if ($status == "approved") {
                    echo "Compra aprovada! Processando a compra...";
                // Redireciona para a tela de visualização após 5 segundos
                echo '<script>
                    setTimeout(function() {
                        window.location.href = "/finalizarCompra?linkCompraID=' . urlencode($linkCompraID) . 
                                                      '&produtoID=' . urlencode($produtoID) . 
                                                      '&chatID=' . urlencode($chatID) . 
                                                      '&vendedorID=' . urlencode($vendedorID) . 
                                                      '&valorBrutoCompra=' . urlencode($valorBrutoCompra) . 
                                                      '&valorCompra=' . urlencode($valorCompra) . 
                                                      '&valorFrete=' . urlencode($valorFrete) . '"; // Adicionando valores na URL
                        }, 5000);
                    </script>';
        } else {
            echo "Deu ruim na compra";
        }
    }
    
}
?>
