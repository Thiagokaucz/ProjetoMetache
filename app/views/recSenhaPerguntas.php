<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Respostas de Segurança - Metache</title>
</head>
<body>
<div class="container">
    <h2>Validação de Segurança</h2>
    <form method="POST" action="/recuperarSenha/perguntas">
        <div class="mb-3">
            <label for="resposta1" class="form-label"><?= htmlspecialchars($_SESSION['pergunta1']) ?></label>
            <input type="text" id="resposta1" name="resposta1" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="resposta2" class="form-label"><?= htmlspecialchars($_SESSION['pergunta2']) ?></label>
            <input type="text" id="resposta2" name="resposta2" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Verificar</button>
    </form>
    <?php if (!empty($erroMensagem)): ?>
        <div class="alert alert-danger mt-3"><?php echo $erroMensagem; ?></div>
    <?php endif; ?>
</div>
</body>
</html>
