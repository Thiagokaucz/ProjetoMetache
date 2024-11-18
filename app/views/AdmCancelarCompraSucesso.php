<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cancelamento de compra</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>cancelamento de compra</h2>

        <div class="alert alert-success mt-3">
            a compra foi cancelada com sucesso, e o status foi atualizado.
        </div>

        <div class="alert alert-warning mt-3">
            <strong>atenção:</strong> é necessário entrar em contato com o comprador para realizar a devolução do dinheiro.
        </div>

        <h3>dados do comprador</h3>
        <ul class="list-group">
            <li class="list-group-item"><strong>nome:</strong> <?php echo htmlspecialchars($comprador['nome'] . ' ' . $comprador['sobrenome']); ?></li>
            <li class="list-group-item"><strong>email:</strong> <?php echo htmlspecialchars($comprador['email']); ?></li>
            <li class="list-group-item"><strong>cep:</strong> <?php echo htmlspecialchars($comprador['cep']); ?></li>
        </ul>

        <a href="/ListPagamentosAdm" class="btn btn-primary mt-3">voltar para lista de pagamentos</a>
    </div>
</body>
</html>
