<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pagamento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 2rem;
            padding: 1.5rem;
            border: 1px solid #dee2e6;
            border-radius: .5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-custom {
            background-color: #FF6B01;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #e65c00;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Detalhes do Pagamento</h2>
        <?php if ($detalhes): ?>
            <table class="table table-bordered">
                <tr><th>ID</th><td><?php echo $detalhes['pagamento']['id']; ?></td></tr>
                <tr><th>Payment ID</th><td><?php echo $detalhes['pagamento']['payment_id']; ?></td></tr>
                <tr><th>Status</th><td><?php echo $detalhes['pagamento']['status']; ?></td></tr>
                <tr><th>Valor da Compra</th><td><?php echo number_format($detalhes['pagamento']['valor_compra'], 2, ',', '.'); ?></td></tr>
                <tr><th>Valor do Frete</th><td><?php echo number_format($detalhes['pagamento']['valor_frete'], 2, ',', '.'); ?></td></tr>
                <tr><th>Data de Criação</th><td><?php echo date('d/m/Y H:i', strtotime($detalhes['pagamento']['created_at'])); ?></td></tr>
                <tr><th>Vendedor</th><td><?php echo $detalhes['vendedor']['nome'] . ' ' . $detalhes['vendedor']['sobrenome']; ?></td></tr>
                <tr><th>Email do Vendedor</th><td><?php echo $detalhes['vendedor']['email']; ?></td></tr>
            </table>
            <form action="/pagamentoVendedor?id=<?php echo $detalhes['pagamento']['id']; ?>" method="post" onsubmit="return confirmarPagamento();">
                <button type="submit" class="btn btn-custom">Realizar pagamento</button>
            </form>
        <?php else: ?>
            <p>Nenhum pagamento encontrado.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
        function confirmarPagamento() {
            return confirm("Tem certeza de que deseja marcar este pagamento como pago?");
        }
    </script>
</body>
</html>
