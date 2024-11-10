<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .notificacao-item {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .notificacao-item:hover {
            background-color: #f8f9fa;
        }
        .produto-imagem {
            max-width: 50px;
            max-height: 50px;
            flex-shrink: 0;
        }
        .notificacao-content {
            flex-grow: 1;
            min-width: 200px;
        }
        .notificacao-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .notificacao-buttons .btn {
            flex: 1 1 100%;
            margin-top: 5px;
        }
        @media (min-width: 576px) {
            .notificacao-buttons .btn {
                flex: 1 1 auto;
                margin-top: 0;
            }
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">

<div class="container mt-5">
    <h1 class="mb-4 text-center">Suas Notificações</h1>

    <div class="list-group">
        <?php if (!empty($notificacoes)): ?>
            <?php foreach ($notificacoes as $notificacao): ?>
                <div class="notificacao-item list-group-item">
                    <?php if (!empty($notificacao['locImagem'])): ?>
                        <img src="/<?= htmlspecialchars($notificacao['locImagem']); ?>" alt="Imagem do Produto" class="produto-imagem">
                    <?php endif; ?>
                    <div class="notificacao-content">
                        <strong><?= htmlspecialchars($notificacao['usuarioNome']); ?> iniciou uma negociação para o produto "<?= htmlspecialchars($notificacao['produtoTitulo']); ?>"</strong><br>
                        <small class="text-muted"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($notificacao['dataHora']))) ?></small>
                    </div>
                    <div class="notificacao-buttons">
                        <?php if (!empty($notificacao['chatID']) && !empty($notificacao['produtoID'])): ?>
                            <button class="btn btn-primary btn-sm"
                                onclick="window.location.href='/chat?Produto=<?= htmlspecialchars($notificacao['produtoID']); ?>&Origem=ListaChat&Tipo=MinhasVendas&chatID=<?= htmlspecialchars($notificacao['chatID']); ?>'">
                                Ir para Chat
                            </button>
                        <?php endif; ?>
                        <button class="btn btn-danger btn-sm" 
                            onclick="window.location.href='/excluir?id=<?= htmlspecialchars($notificacao['notificacaoID']); ?>'">
                            Excluir
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted text-center">Você não tem notificações.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
