<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tela de Recuperação de Senha Metache">
    <title>Recuperar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> <!-- Adicionando Bootstrap Icons -->
</head>

<body class="vh-100 d-flex align-items-center justify-content-center">
    <section class="container">
        <div class="row justify-content-sm-center">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center">
                        <img src="/public/img/Metache.png" alt="logo" width="150">
                        <h4 class="fs-5 text-muted mb-4 mt-3">Recuperação de Senha</h4>
                        </div>
                        <form method="POST" class="needs-validation" novalidate="" autocomplete="off" action="/recuperarSenha/email">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="email">E-mail</label>
                                <input id="email" type="email" class="form-control" name="email" required autofocus>
                                <div class="invalid-feedback">
                                    Por favor, insira um e-mail válido.
                                </div>
                            </div>
                            <div class="d-grid gap-2 mx-auto">
                                <button class="btn btn-primary" type="submit" style="background-color: #FF6B01; border-color: #FF6B01;">Enviar</button>
                            </div>
                        </form>

                        <!-- Mensagem de erro -->
                        <?php if (!empty($erroMensagem)): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php echo $erroMensagem; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Lembrou sua senha? <a href="/login" class="text-dark">Faça login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
