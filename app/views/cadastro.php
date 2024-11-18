<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
        <link rel="shortcut icon" href="public/img/metacheIc.ico" /> 
    <link rel="shortcut icon" href="public/img/metacheIc.ico" /> 

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tela de cadastro Metache">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .eye-icon {
            cursor: pointer;
        }
    </style>
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
                        <form id="cadastroForm" method="POST" class="needs-validation" novalidate="" autocomplete="off" action="/cadastroUsuario">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="nome">Nome</label>
                                <input id="nome" type="text" class="form-control" name="nome" required>
                                <div class="invalid-feedback">
                                    O nome é obrigatório.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="sobrenome">Sobrenome</label>
                                <input id="sobrenome" type="text" class="form-control" name="sobrenome" required>
                                <div class="invalid-feedback">
                                    O sobrenome é obrigatório.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="email">E-Mail</label>
                                <input id="email" type="email" class="form-control" name="email" required>
                                <div class="invalid-feedback">
                                    Digite um e-mail válido, como exemplo@dominio.com.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="senha">Senha</label>
                                <div class="input-group">
                                    <input id="senha" type="password" class="form-control" name="senha" required>
                                    <span class="input-group-text eye-icon" id="togglePassword">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                </div>
                                <div class="invalid-feedback">
                                    A senha é obrigatória.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="cep">CEP</label>
                                <input id="cep" type="text" class="form-control" name="cep" required pattern="\d{5}-?\d{3}" placeholder="12345-123">
                                <div class="invalid-feedback">
                                    Digite um CEP válido, como 12345-678.
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="aceitarTermos" required>
                                <label class="form-check-label" for="aceitarTermos">
                                    Aceito os <a href="/TermosUso" target="_blank" class="text-decoration-none" style="color: #FF6B01;">termos de uso</a>.
                                </label>
                                <div class="invalid-feedback">
                                    Você deve aceitar os termos de uso.
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 mx-auto">
                                <button type="button" class="btn btn-primary" onclick="validarFormulario()" style="background-color: #FF6B01; border-color: #FF6B01;">Cadastrar</button>
                            </div>
                        </form>

                        <?php if (!empty($errorMessage)): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php echo $errorMessage; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Já tem uma conta? <a href="/login" class="text-dark">Fazer login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function validarFormulario() {
            var aceitarTermos = document.getElementById('aceitarTermos');
            if (!aceitarTermos.checked) {
                alert('Você deve aceitar os termos de uso.');
            } else {
                document.getElementById('cadastroForm').submit();
            }
        }

        const togglePassword = document.getElementById('togglePassword');
        const senhaInput = document.getElementById('senha');

        togglePassword.addEventListener('click', function () {
            const type = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
            senhaInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });

        document.getElementById('cep').addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9-]/g, '');
            validarCampo(this, /^\d{5}-?\d{3}$/);
        });

        document.getElementById('email').addEventListener('input', function () {
            validarCampo(this, /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/);
        });

document.getElementById('nome').addEventListener('input', function () {
    validarCampo(this, /^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/); 
});

document.getElementById('sobrenome').addEventListener('input', function () {
    validarCampo(this, /^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/); 
});


        document.getElementById('senha').addEventListener('input', function () {
            validarCampo(this, /.+/);
        });

        function validarCampo(campo, regex) {
            if (regex.test(campo.value)) {
                campo.classList.add('is-valid');
                campo.classList.remove('is-invalid');
            } else {
                campo.classList.add('is-invalid');
                campo.classList.remove('is-valid');
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
