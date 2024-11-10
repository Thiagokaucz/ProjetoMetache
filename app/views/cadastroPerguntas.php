<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perguntas de Segurança</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="vh-100 d-flex align-items-center justify-content-center">
    <section class="container">
        <div class="row justify-content-sm-center">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h4 class="fs-5 text-muted mb-4 text-center">Configurar Perguntas de Segurança</h4>
                        <p>A plataforma Metache gostaria de configurar perguntas de segurança para ajudar na recuperação de senha, caso necessário. Deseja configurar agora?</p>
                        <form id="perguntasForm" method="POST" action="?userID=<?php echo htmlspecialchars($_GET['userID']); ?>">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="pergunta1">Pergunta de Segurança 1</label>
                                <select id="pergunta1" name="pergunta1" class="form-select">
                                    <option value="">Escolha uma pergunta...</option>
                                    <option value="Qual é o nome do seu primeiro animal de estimação?">Qual é o nome do seu primeiro animal de estimação?</option>
                                    <option value="Qual é o nome da sua escola primária?">Qual é o nome da sua escola primária?</option>
                                    <option value="Em que cidade você nasceu?">Em que cidade você nasceu?</option>
                                </select>
                                <input type="text" name="resposta1" class="form-control mt-2" placeholder="Resposta">
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="pergunta2">Pergunta de Segurança 2</label>
                                <select id="pergunta2" name="pergunta2" class="form-select">
                                    <option value="">Escolha uma pergunta...</option>
                                    <option value="Qual é o nome da sua mãe?">Qual é o nome da sua mãe?</option>
                                    <option value="Qual era o nome do seu melhor amigo de infância?">Qual era o nome do seu melhor amigo de infância?</option>
                                    <option value="Qual é o seu filme favorito?">Qual é o seu filme favorito?</option>
                                </select>
                                <input type="text" name="resposta2" class="form-control mt-2" placeholder="Resposta">
                            </div>

                            <?php if (!empty($errorMessage)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $errorMessage; ?>
                                </div>
                            <?php endif; ?>

                            <div class="d-grid gap-2 mx-auto">
                                <button type="submit" class="btn btn-primary" style="background-color: #FF6B01; border-color: #FF6B01;">Salvar Perguntas</button>
                                <button type="submit" name="skip" class="btn btn-secondary">Pular</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
