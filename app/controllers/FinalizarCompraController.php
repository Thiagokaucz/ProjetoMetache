<?php
session_start();

require_once 'app/models/FinalizarCompraModel.php';

class FinalizarCompraController {
    private $finalizarCompraModel;

    public function __construct() {
        $this->finalizarCompraModel = new FinalizarCompraModel();
    }

    public function processar() {
        // Obtendo os parâmetros da URL
        $linkCompraID = $_GET['linkCompraID'] ?? null;
        $produtoID = $_GET['produtoID'] ?? null;
        $chatID = $_GET['chatID'] ?? null;
        $vendedorID = $_GET['vendedorID'] ?? null;
        
        // Recebendo os valores da compra
        $valorBrutoCompra = $_GET['valorBrutoCompra'] ?? null;
        $valorCompra = $_GET['valorCompra'] ?? null;
        $valorFrete = $_GET['valorFrete'] ?? null;

        // Obtendo o compradorID da sessão
        $compradorID = $_SESSION['user_id'] ?? null;

        // Verificando se todos os parâmetros estão presentes
        if ($produtoID && $chatID && $compradorID && $vendedorID && $valorBrutoCompra && $valorCompra && $valorFrete) {
            // Chama o método do modelo para finalizar a compra
            if ($this->finalizarCompraModel->finalizarCompra($produtoID, $chatID, $compradorID, $vendedorID, $valorCompra, $valorFrete)) {
                // Agora, atualiza a tabela compraspagamento
                if ($this->finalizarCompraModel->atualizarAquisicaoIDPorProduto($produtoID)) {
                    // Mensagem de sucesso
                    echo "Compra realizada com sucesso e aquisicaoID atualizada!";
                } else {
                    echo "Compra realizada, mas erro ao atualizar aquisicaoID.";
                }
                
                // Redireciona para /minhascompras após 5 segundos
                echo '<script>
                    setTimeout(function() {
                        window.location.href = "/minhasCompras";
                    }, 5000);
                </script>';
            } else {
                echo "Erro ao realizar a compra. Tente novamente.";
            }
        } else {
            echo "Parâmetros inválidos. Verifique os dados fornecidos.";
            // Você pode exibir os parâmetros para depuração
            // echo $produtoID . "&" . $chatID . "&" . $compradorID . "&" . $vendedorID;
        }
    }
}
?>
