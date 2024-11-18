<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <title>Enviar Produto</title>
    <style>
        .btn-custom {
            background-color: #FF6B01;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Enviar Produto</h1>

        <form action="/enviarProdutoForm?aquisicaoID=<?= htmlspecialchars($aquisicaoID) ?>" method="POST" class="bg-light p-4 rounded shadow">
            <div class="mb-3">
                <label for="transportadora" class="form-label">Transportadora:</label>
                <input type="text" name="transportadora" id="transportadora" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="codigoRastreio" class="form-label">Código de Rastreio:</label>
                <input type="text" name="codigoRastreio" id="codigoRastreio" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="comentario" class="form-label">Comentário:</label>
                <textarea name="comentario" id="comentario" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="dataHora" class="form-label">Data e Hora do Envio:</label>
                <input type="datetime-local" name="dataHora" id="dataHora" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-custom">Enviar Produto</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
