<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações</title>
    <style>
        .notificacao-item {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
        }
        .notificacao-item:hover {
            background-color: #f8f9fa;
        }
        .produto-imagem {
            max-width: 50px;
            max-height: 50px;
            margin-right: 15px;
        }
        .notificacao-content {
            flex-grow: 1;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1>Suas Notificações</h1>

    <div class="list-group">
        <?php if (!empty($notificacoes)): ?>
            <?php foreach ($notificacoes as $notificacao): ?>
                <div class="notificacao-item list-group-item d-flex justify-content-between align-items-center">
                    <?php if (!empty($notificacao['locImagem'])): ?>
                        <img src="/<?= htmlspecialchars($notificacao['locImagem']); ?>" alt="Imagem do Produto" class="produto-imagem">
                    <?php endif; ?>
                    <div class="notificacao-content">
                        <strong><?= htmlspecialchars($notificacao['usuarioNome']); ?> iniciou uma negociação para o produto "<?= htmlspecialchars($notificacao['produtoTitulo']); ?>"</strong><br>
                        <small class="text-muted"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($notificacao['dataHora']))) ?></small>
                    </div>
                    <?php if (!empty($notificacao['chatID']) && !empty($notificacao['produtoID'])): ?>
                        <button class="btn negociar-btn btn-block mt-2" 
                            onclick="window.location.href='/chat?Produto=<?= htmlspecialchars($notificacao['produtoID']); ?>&Origem=ListaChat&Tipo=MinhasVendas&chatID=<?= htmlspecialchars($notificacao['chatID']); ?>'">
                            Ir para Chat
                        </button>
                    <?php endif; ?>
                    <button class="btn negociar-btn btn-block mt-2" 
                        onclick="window.location.href='/excluir?id=<?= htmlspecialchars($notificacao['notificacaoID']); ?>'">
                        Excluir
                    </button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Você não tem notificações.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
