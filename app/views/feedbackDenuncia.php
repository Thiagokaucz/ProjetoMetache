<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback de Denúncia</title>
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
    <div class="container text-center">
        <h1 class="mb-4">Feedback de Denúncia</h1>
        <p class="lead"><?= htmlspecialchars($mensagem) ?></p>
        
        <a href="/" class="btn btn-secondary">Voltar à página inicial</a>
    </div>

    <!-- Bootstrap JS (Opcional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
