<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras Pendentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
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
        .table-primary-custom {
            background-color: #FF6B01;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container table-container">
        <h2 class="mb-4">Compras Pendentes</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="table-primary-custom">
                    <th>ID</th>
                    <th>Payment ID</th>
                    <th>Status</th>
                    <th>Valor da Compra</th>
                    <th>Valor do Frete</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($compras)): ?>
                    <?php foreach ($compras as $compra): ?>
                        <tr>
                            <td><?php echo $compra['id']; ?></td>
                            <td><?php echo $compra['payment_id']; ?></td>
                            <td><?php echo $compra['status']; ?></td>
                            <td><?php echo number_format($compra['valor_compra'], 2, ',', '.'); ?></td>
                            <td><?php echo number_format($compra['valor_frete'], 2, ',', '.'); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($compra['created_at'])); ?></td>
                            <td>
                                <a href="PagamentoAdm?id=<?php echo $compra['id']; ?>" class="btn btn-custom">Finalizar venda</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Nenhuma compra pendente encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
