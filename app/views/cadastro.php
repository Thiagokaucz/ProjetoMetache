<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tela de cadastro Metache">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body class="vh-100 d-flex align-items-center justify-content-center">
    <section class="container">
        <div class="row justify-content-sm-center">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                    <div class="text-center">
                            <img src="public/img/Metache.png" alt="logo" width="150">
							<h4 class="fs-5 text-muted mb-4 mt-3">Crie sua conta grátis</h4>
						</div>
                        <form method="POST" class="needs-validation" novalidate="" autocomplete="off" action="/cadastroUsuario">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="nome">Nome</label>
                                <input id="nome" type="text" class="form-control" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="sobrenome">Sobrenome</label>
                                <input id="sobrenome" type="text" class="form-control" name="sobrenome" required>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="email">E-Mail</label>
                                <input id="email" type="email" class="form-control" name="email" required>
                                <div class="invalid-feedback">
                                    Endereço de e-mail inválido.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="senha">Senha</label>
                                <input id="senha" type="password" class="form-control" name="senha" required>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="cep">CEP</label>
                                <input id="cep" type="text" class="form-control" name="cep" required>
                            </div>
                            <div class="d-grid gap-2 mx-auto">
                                <button class="btn btn-primary" type="submit" style="background-color: #FF6B01; border-color: #FF6B01;">Cadastrar</button>
                            </div>
                        </form>

                        <!-- Mensagem de erro -->
                        <?php if (!empty($errorMessage)): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php echo $errorMessage; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Já tem uma conta? <a href="login.php" class="text-dark">Fazer login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
