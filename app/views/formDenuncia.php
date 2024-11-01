<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denunciar Produto</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Cor de fundo suave */
        }
        .container {
            margin-top: 50px; /* Espaçamento no topo */
        }
        .btn-custom {
            background-color: #FF6B01;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Denunciar Produto</h1>

        <form action="/enviarDenuncia" method="POST" class="border p-4 rounded shadow">
            <input type="hidden" name="aquisicaoID" value="<?= htmlspecialchars($_GET['aquisicaoID']) ?>">

            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo da Denúncia:</label>
                <textarea name="motivo" id="motivo" class="form-control" rows="4" required></textarea>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="submit" class="btn btn-custom me-2">Enviar Denúncia</button>
                <a href="/" class="btn btn-secondary">Voltar à página inicial</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS (Opcional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
