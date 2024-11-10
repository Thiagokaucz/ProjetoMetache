<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
</head>
<body>
<div class="container">
    <h2>Definir Nova Senha</h2>
    <form method="POST" action="/recuperarSenha/novaSenha">
        <div class="mb-3">
            <label for="novaSenha" class="form-label">Nova Senha</label>
            <input type="password" id="novaSenha" name="novaSenha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Nova Senha</button>
    </form>
</div>
</body>
</html>
