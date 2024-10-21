<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Compra</title>
    <link rel="stylesheet" href="path/to/your/style.css"> <!-- Substitua pelo caminho correto -->
</head>
<body>
    <h1>Detalhes da Compra</h1>

    <?php if ($dados): ?>
        <h2>Link de Compra ID: <?= htmlspecialchars($dados['linkCompraID']) ?></h2>
        <p><strong>Valor Bruto Compra:</strong> <?= htmlspecialchars($dados['valorBrutoCompra']) ?></p>
        <p><strong>Valor da Compra:</strong> <?= htmlspecialchars($dados['valorCompra']) ?></p>
        <p><strong>Status do Link de Compra:</strong> <?= htmlspecialchars($dados['statusLinkCompra']) ?></p>
        <p><strong>Valor do Frete:</strong> <?= htmlspecialchars($dados['valorFrete']) ?></p>

        <h2>Dados do Produto</h2>
        <h2>Dados do Produto</h2>
        <p><strong>Produto ID:</strong> <?= htmlspecialchars($dados['produtoID']) ?></p>
        <p><strong>Nome do Produto:</strong> <?= htmlspecialchars($dados['titulo']) ?></p>
        <p><strong>Descrição do Produto:</strong> <?= htmlspecialchars($dados['descricao']) ?></p>
        <p><strong>Preço do Produto:</strong> <?= htmlspecialchars($dados['valor']) ?></p>

    <?php else: ?>
        <p>Nenhum dado encontrado para este link de compra.</p>
    <?php endif; ?>

    <a href="/chat">Voltar</a> <!-- Link de navegação de volta -->
</body>
</html>
