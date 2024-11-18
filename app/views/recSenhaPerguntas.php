<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
        <link rel="shortcut icon" href="public/img/metacheIc.ico" /> 

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tela de Validação de Segurança Metache">
    <title>Validação de Segurança</title>
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
                        <img src="/public/img/Metache.png" alt="logo" width="150">
                            <h4 class="fs-5 text-muted mb-4 mt-3">Validação de Segurança</h4>
                        </div>
                        <form method="POST" action="/recuperarSenha/perguntas" autocomplete="off">
                            <div class="mb-3">
                                <label for="resposta1" class="form-label"><?= htmlspecialchars($_SESSION['pergunta1']) ?></label>
                                <input type="text" id="resposta1" name="resposta1" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="resposta2" class="form-label"><?= htmlspecialchars($_SESSION['pergunta2']) ?></label>
                                <input type="text" id="resposta2" name="resposta2" class="form-control" required>
                            </div>
                            <div class="d-grid gap-2 mx-auto">
                                <button type="submit" class="btn btn-primary" style="background-color: #FF6B01; border-color: #FF6B01;">Verificar</button>
                            </div>
                        </form>

                        <?php if (!empty($erroMensagem)): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php echo $erroMensagem; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
