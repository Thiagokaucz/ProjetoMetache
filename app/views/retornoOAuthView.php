<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Autorização</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 500px;
            margin-top: 50px;
            text-align: center;
        }
        .step {
            display: none;
            margin-top: 20px;
            font-size: 1.1rem;
            color: #FF6B01;
        }
        .logo {
            width: 150px;
            margin-bottom: 20px;
        }
    </style>
    <script>
        // Função para mostrar as etapas gradativamente
        function mostrarEtapas() {
            const etapas = document.querySelectorAll('.step');
            let etapaAtual = 0;
            
            const mostrarProximaEtapa = () => {
                if (etapaAtual < etapas.length) {
                    etapas[etapaAtual].style.display = 'block';
                    etapaAtual++;
                    setTimeout(mostrarProximaEtapa, 1500);
                } else {
                    // Redireciona para a página de anúncio após a última etapa
                    setTimeout(() => {
                        window.location.href = '/anunciar';
                    }, 2000);
                }
            };
            
            mostrarProximaEtapa();
        }

        document.addEventListener("DOMContentLoaded", mostrarEtapas);
    </script>
</head>
<body class="bg-light">

<div class="container">
    <img src="public/img/Metache.png" alt="Logo Metache" class="logo">
    <h1>Autorização Concluída</h1>
    
    <?php if (isset($erro)): ?>
        <p class="text-danger"><?= htmlspecialchars($erro) ?></p>
    <?php else: ?>
        <p>Estamos vinculando sua conta. Por favor, aguarde...</p>
        <div class="step">🔄 Vinculando sua conta ao Mercado Pago...</div>
        <div class="step">⏳ Preparando os últimos detalhes...</div>
        <div class="step">✅ Conta vinculada com sucesso!</div>
    <?php endif; ?>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
