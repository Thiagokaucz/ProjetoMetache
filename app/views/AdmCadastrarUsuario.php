<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cadastro do Administrador">
    <title>Cadastro do Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <section class="container">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h4 class="fs-5 text-muted mb-4 mt-3">Cadastrar Administrador</h4>
                        <form method="POST" class="needs-validation" novalidate="">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="nome">Nome</label>
                                <input id="nome" type="text" class="form-control" name="nome" required autofocus>
                                <div class="invalid-feedback">Nome inválido</div>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="usuario">Usuário</label>
                                <input id="usuario" type="text" class="form-control" name="usuario" required>
                                <div class="invalid-feedback">Usuário inválido</div>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="senha">Senha</label>
                                <input id="senha" type="password" class="form-control" name="senha" required>
                                <div class="invalid-feedback">Senha inválida</div>
                            </div>
                            <div class="d-grid gap-2 mx-auto">
                                <button class="btn btn-primary" type="submit" style="background-color: #FF6B01; border-color: #FF6B01;">Cadastrar</button>
                            </div>
                        </form>
                        <!-- Mensagem de erro -->
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
