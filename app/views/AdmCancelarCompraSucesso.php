<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelamento de Compra</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Cancelamento de Compra</h2>
        <div class="alert alert-success mt-3">
            A compra foi cancelada com sucesso, e o status foi atualizado.
        </div>

        <!-- Aviso para contato com o comprador -->
        <div class="alert alert-warning mt-3">
            <strong>Atenção:</strong> É necessário entrar em contato com o comprador para realizar a devolução do dinheiro.
        </div>

        <!-- Exibindo informações do comprador -->
        <h3>Dados do Comprador</h3>
        <ul class="list-group">
            <li class="list-group-item"><strong>Nome:</strong> <?php echo htmlspecialchars($comprador['nome'] . ' ' . $comprador['sobrenome']); ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($comprador['email']); ?></li>
            <li class="list-group-item"><strong>CEP:</strong> <?php echo htmlspecialchars($comprador['cep']); ?></li>
        </ul>

        <a href="/ListPagamentosAdm" class="btn btn-primary mt-3">Voltar para lista de pagamentos</a>
    </div>
</body>
</html>
