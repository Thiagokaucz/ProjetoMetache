<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Documentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            background-color: #FF6B01;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #e65c00;
        }
        .btn-custom:focus, .btn-custom:active {
            background-color: #cc5200;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 1, 0.5);
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h2 class="mb-0">Anexar Documentos de Pagamento</h2>
                    </div>
                    <div class="card-body">

                    <form action="/anexarDocumentos" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="compraspagamento" value="<?php echo htmlspecialchars($_GET['compraspagamento']); ?>">

                            <div class="mb-3">
                                <label for="notaFiscal" class="form-label">Nota Fiscal (PDF):</label>
                                <input type="file" class="form-control" name="notaFiscal" id="notaFiscal" accept="application/pdf" required>
                            </div>

                            <div class="mb-3">
                                <label for="compPagamento" class="form-label">Comprovante de Pagamento (PDF):</label>
                                <input type="file" class="form-control" name="compPagamento" id="compPagamento" accept="application/pdf" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-custom">Anexar e Finalizar Compra</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
