<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha - Metache</title>
</head>
<body>
<div class="container">
    <h2>Recuperar Senha</h2>
    <form method="POST" action="/recuperarSenha/email">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    <?php if (!empty($erroMensagem)): ?>
        <div class="alert alert-danger mt-3"><?php echo $erroMensagem; ?></div>
    <?php endif; ?>
</div>
</body>
</html>
