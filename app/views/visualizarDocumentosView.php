<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Documentos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1 class="display-5">Comprovante de Compra e Nota Fiscal</h1>
            <p class="text-muted">Visualize os documentos relacionados à sua compra</p>
        </div>

        <?php if (isset($documentos['compPagamento']) && isset($documentos['notaFiscal'])): ?>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Comprovante de Pagamento</h5>
                        </div>
                        <div class="card-body">
                            <iframe src="<?= htmlspecialchars($documentos['compPagamento']) ?>" class="w-100" style="height: 500px; border: none;"></iframe>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Nota Fiscal</h5>
                        </div>
                        <div class="card-body">
                            <iframe src="<?= htmlspecialchars($documentos['notaFiscal']) ?>" class="w-100" style="height: 500px; border: none;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                Os documentos não foram encontrados.
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
