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
        }
        .notificacao-item:hover {
            background-color: #f8f9fa;
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
                    <div>
                        <strong><?= htmlspecialchars($notificacao['conteudo']) ?></strong><br>
                        <small class="text-muted"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($notificacao['dataHora']))) ?></small>
                    </div>
                    <button class="btn negociar-btn btn-block mt-2" 
                        onclick="window.location.href='/excluir?id=<?php echo ($notificacao['notificacaoID']);?>'">
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
