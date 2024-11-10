<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Autorização</title>
</head>
<body>
    <h1>Resultado da Autorização OAuth</h1>
    
    <?php if (isset($erro)): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
    <?php elseif (isset($token_data['access_token'])): ?>
        <h2>Token de Acesso:</h2>
        <ul>
            <li><strong>Access Token:</strong> <?= htmlspecialchars($token_data['access_token']) ?></li>
            <li><strong>Token Type:</strong> <?= htmlspecialchars($token_data['token_type']) ?></li>
            <li><strong>Expires In:</strong> <?= htmlspecialchars($token_data['expires_in']) ?> segundos</li>
            <li><strong>Scope:</strong> <?= htmlspecialchars($token_data['scope']) ?></li>
            <li><strong>User ID:</strong> <?= htmlspecialchars($token_data['user_id']) ?></li>
            <li><strong>Refresh Token:</strong> <?= htmlspecialchars($token_data['refresh_token']) ?></li>
            <li><strong>Public Key:</strong> <?= htmlspecialchars($token_data['public_key']) ?></li>
            <li><strong>Live Mode:</strong> <?= $token_data['live_mode'] ? 'Sim' : 'Não' ?></li>
        </ul>
        <p>Token salvo com sucesso no banco de dados para o usuário com ID <?= htmlspecialchars($_SESSION['user_id']) ?>.</p>
    <?php endif; ?>
    
            <button onclick="window.location.href='/anunciar'">Voltar</button>
</body>
</html>
