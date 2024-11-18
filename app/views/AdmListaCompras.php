<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
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
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container table-container">
        <h2 class="mb-4">Compras Pendentes</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="table-primary-custom">
                    <th>Pagamento ID</th>
                    <th>Valor da Compra</th>
                    <th>Data do pagamento</th>
                    <th>Status</th>
                    <th>Produto</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($compras)): ?>
                    <?php foreach ($compras as $compra): ?>
                        <tr>
                            <td><?php echo $compra['payment_id']; ?></td>
                            <td><?php echo number_format($compra['valor_compra'], 2, ',', '.'); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($compra['created_at'])); ?></td>
                            <td><?php echo ucwords(str_replace('_', ' ', htmlspecialchars($compra['statusAdmMetache']))); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo htmlspecialchars($compra['locImagem']); ?>" alt="Imagem do produto" class="product-image me-2">
                                    <span><?php echo htmlspecialchars($compra['titulo']); ?></span>
                                </div>
                            </td>
                            <td>
                                <a href="PagamentoAdm?id=<?php echo $compra['id']; ?>" class="btn btn-custom">Finalizar venda</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma compra pendente encontrada.</td>
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
