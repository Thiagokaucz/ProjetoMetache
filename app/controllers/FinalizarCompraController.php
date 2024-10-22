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

        // Obtendo o compradorID da sessão
        $compradorID = $_SESSION['user_id'] ?? null;

        // Verificando se todos os parâmetros estão presentes
        if ($produtoID && $chatID && $compradorID && $vendedorID) {
            // Chama o método do modelo para finalizar a compra
            if ($this->finalizarCompraModel->finalizarCompra($produtoID, $chatID, $compradorID, $vendedorID)) {
                // Mensagem de sucesso
                echo "Compra realizada com sucesso!";
                // Redireciona para /minhascompras após 5 segundos
                echo '<script>
                    setTimeout(function() {
                        window.location.href = "/minhascompras";
                    }, 5000);
                </script>';
            } else {
                echo "Erro ao realizar a compra. Tente novamente.";
            }
        } else {
            echo "Parâmetros inválidos. Verifique os dados fornecidos.";
            //echo $produtoID . "&" . $chatID . "&" . $compradorID . "&" . $vendedorID;

        }
    }
}
?>
