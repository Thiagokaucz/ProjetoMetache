<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Vendedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
        }
        .bordered-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1rem;
        }
        .text-highlight {
            color: #FF6B01;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #FF6B01;
            color: white;
            border: none;
        }
        .btn-primary:hover {
            background-color: #e65b00;
        }
        .btn-secondary {
            border-color: #6c757d;
        }
        .button-container {
            max-width: 400px; 
            margin: 0 auto; 
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="bordered-box text-center">
        <h3 class="fw-bold mb-3">Metache informa</h3>
        <p class="mb-4">Você precisa estar cadastrado como vendedor para anunciar produtos.</p>
        <div class="d-grid gap-2 mt-4 button-container">
            <button class="btn btn-secondary mb-2" onclick="window.location.href='/'">Voltar</button>
            <button class="btn btn-primary" onclick="window.location.href='/linkOAoth'">Vincular conta Mercado Pago</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
