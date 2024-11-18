<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tela de login Metache">
    <title>Login</title>
        <link rel="shortcut icon" href="public/img/metacheIc.ico" /> 

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body class="vh-100 d-flex align-items-center justify-content-center">
    <section class="container">
        <div class="row justify-content-sm-center">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <img src="public/img/Metache.png" alt="logo" width="150">
                            <h4 class="fs-5 text-muted mb-4 mt-3">Acesse sua conta</h4>
                        </div>
                        <form method="POST" class="needs-validation" novalidate="" autocomplete="off" action="/login">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="email">E-Mail</label>
                                <input id="email" type="email" class="form-control" name="email" required autofocus>
                                <div class="invalid-feedback">
                                    Email inválido
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="mb-2 w-100">
                                    <label class="text-muted" for="senha">Senha</label>
                                    <a href="/recuperarSenha/email" class="float-end text-decoration-none" style="color: #FF6B01;">
                                        Esqueceu a senha?
                                    </a>
                                </div>
                                <div class="input-group">
                                    <input id="senha" type="password" class="form-control" name="senha" required>
                                    <span class="input-group-text eye-icon" id="togglePassword">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                </div>
                                <div class="invalid-feedback">
                                    Senha inválida
                                </div>
                            </div>

                            <div class="d-grid gap-2 mx-auto">
                                <button class="btn btn-primary" type="submit" style="background-color: #FF6B01; border-color: #FF6B01;">Entrar</button>
                            </div>
                        </form>

                        <?php if (!empty($erroMensagem)): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php echo $erroMensagem; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Não tem uma conta? <a href="/cadastroUsuario" class="text-dark">Criar conta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const senhaInput = document.getElementById('senha');

        togglePassword.addEventListener('click', function () {
            
            const type = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
            senhaInput.setAttribute('type', type);

            this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });

    </script>
</body>
</html>
