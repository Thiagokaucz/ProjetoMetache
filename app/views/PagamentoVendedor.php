<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento ao Vendedor</title>
</head>
<body>
    <div class="container">
        <h2>Pagamento ao Vendedor</h2>

        <?php if (!empty($compra)): ?>
            <p><strong>ID da Compra:</strong> <?php echo htmlspecialchars($compra['id']); ?></p>
            <p><strong>Produto ID:</strong> <?php echo htmlspecialchars($compra['produtoID']); ?></p>
            <p><strong>Valor da Compra:</strong> R$ <?php echo number_format($compra['valor_compra'], 2, ',', '.'); ?></p>
            <p><strong>Valor do Pagamento ao Vendedor (5%):</strong> R$ <?php echo number_format($valorPagamento, 2, ',', '.'); ?></p>

            <form action="localhost/pagamentoVendedor?id=<?php echo htmlspecialchars($compra['id']); ?>" method="POST">
                <input type="hidden" name="acao" value="pagar">
                <button type="submit" class="btn btn-primary">Realizar Pagamento</button>
            </form>
        <?php else: ?>
            <p>Compra não encontrada.</p>
        <?php endif; ?>
    </div>
</body>
</html>
