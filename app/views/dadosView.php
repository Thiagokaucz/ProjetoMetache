<!-- views/dadosView.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados Retornados</title>
</head>
<body>
    <h1>Dados Retornados</h1>
    <?php if (isset($dados['codigo_autorizacao'])): ?>
        <p><strong>Código de Autorização:</strong> <?php echo htmlspecialchars($dados['codigo_autorizacao']); ?></p>
    <?php else: ?>
        <p><strong>Erro:</strong> <?php echo htmlspecialchars($dados['erro']); ?></p>
    <?php endif; ?>
</body>
</html>
