<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="cadastro do administrador">
    <title>cadastro do administrador</title>
    <link rel="shortcut icon" href="public/img/metacheIc.ico" /> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <section class="container">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <h4 class="fs-5 text-muted mb-4 mt-3">cadastrar administrador</h4>
                <form method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="nome">nome</label>
                        <input id="nome" type="text" class="form-control" name="nome" required autofocus>
                        <div class="invalid-feedback">nome inválido</div>
                    </div>
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="usuario">usuário</label>
                        <input id="usuario" type="text" class="form-control" name="usuario" required>
                        <div class="invalid-feedback">usuário inválido</div>
                    </div>
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="senha">senha</label>
                        <input id="senha" type="password" class="form-control" name="senha" required>
                        <div class="invalid-feedback">senha inválida</div>
                    </div>
                    <div class="d-grid gap-2 mx-auto">
                        <button class="btn btn-primary" type="submit" style="background-color: #ff6b01; border-color: #ff6b01;">cadastrar</button>
                    </div>
                </form>
                <?php if (!empty($erroMensagem)): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $erroMensagem; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>
