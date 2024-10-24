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
            $aprovacao = isset($_POST['aprovacao']) ? htmlspecialchars($_POST['aprovacao']) : null; // Nova variável para aprovação

            // Se a ação é de comprar, exibe a tela de aprovação
            if ($acao === 'comprar') {
                echo "<h2>Detalhes da Compra</h2>";
                echo "Link de Compra ID: " . $linkCompraID . "<br>";
                echo "Produto ID: " . $produtoID . "<br>";
                echo "Chat ID: " . $chatID . "<br>";
                echo "Usuário ID: " . $userID . "<br>";
                echo "Vendedor ID: " . htmlspecialchars($vendedorID) . "<br>"; // Exibe o vendedorID
                echo "Valor Bruto Compra: " . htmlspecialchars($valorBrutoCompra) . "<br>";
                echo "Valor da Compra: " . htmlspecialchars($valorCompra) . "<br>";
                echo "Valor do Frete: " . htmlspecialchars($valorFrete) . "<br>";

                // Formulário de aprovação
                echo '
                <form action="" method="POST">
                    <input type="hidden" name="linkCompraID" value="' . htmlspecialchars($linkCompraID) . '">
                    <input type="hidden" name="produtoID" value="' . htmlspecialchars($produtoID) . '">
                    <input type="hidden" name="chatID" value="' . htmlspecialchars($chatID) . '">
                    <input type="hidden" name="vendedorID" value="' . htmlspecialchars($vendedorID) . '"> <!-- Adicionando o vendedorID -->
                    <input type="hidden" name="valorBrutoCompra" value="' . htmlspecialchars($valorBrutoCompra) . '"> <!-- Passando valor bruto -->
                    <input type="hidden" name="valorCompra" value="' . htmlspecialchars($valorCompra) . '"> <!-- Passando valor da compra -->
                    <input type="hidden" name="valorFrete" value="' . htmlspecialchars($valorFrete) . '"> <!-- Passando valor do frete -->
                    <input type="hidden" name="acao" value="comprar">

                    <h3>DEBUG -- Aprovar a compra? -- DEBUG</h3>
                    <button type="submit" name="aprovacao" value="sim">Aprovar Compra</button>
                    <button type="submit" name="aprovacao" value="nao">Recusar Compra</button>
                </form>';
            }

            // Processa a aprovação
            if ($aprovacao) {
                if ($aprovacao === 'sim') {
                    echo "Compra aprovada! Processando a compra...";
                } elseif ($aprovacao === 'nao') {
                    echo "Compra rejeitada.";
                } else {
                    echo "Aprovação não fornecida.";
                }

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
                echo "Ação não reconhecida.";
            }
        } else {
            echo "Método de requisição inválido.";
        }
    }
}
?>
