<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body style="background-color: #f0f0f5;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="public/img/Metache.png" alt="Logo" height="25" width="auto">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sobre">Sobre</a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/minhasCompras">Minhas compras</a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/meusAnuncios">Meus anuncios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/chatLista">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/notificacoes">Notificações</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/usuario"><span class="bi bi-person"></span> <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/anunciar" style="color: orange;">Anunciar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout" style="color: red;"><span class="bi bi-box-arrow-right"></span> Sair</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login"><span class="bi bi-person"></span> Entrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/anunciar" style="color: #FF6B01;">Anunciar</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
