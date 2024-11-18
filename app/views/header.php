<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<<<<<<< HEAD
=======
    <link rel="shortcut icon" href="public/img/metacheIc.ico" /> 
>>>>>>> develop
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body style="background-color: #f0f0f5;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
<<<<<<< HEAD
            <a class="navbar-brand" href="#">
=======
            <a class="navbar-brand" href="/">
>>>>>>> develop
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
<<<<<<< HEAD
                        <a class="nav-link" href="/sobre">Sobre</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="comprasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Minhas Compras
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="comprasDropdown">
                            <li><a class="dropdown-item" href="/compras">Minhas Compras 1</a></li>
                            <li><a class="dropdown-item" href="/compras">Minhas Compras 2</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="anunciosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Meus Anúncios
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="anunciosDropdown">
                            <li><a class="dropdown-item" href="/meusAnuncios">Meus Anúncios 1</a></li>
                            <li><a class="dropdown-item" href="/meusAnuncios">Meus Anúncios 2</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/chat">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/notificacoes">Notificações</a>
                    </li>
=======
                        <a class="nav-link" href="/minhasCompras">Minhas compras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/meusAnuncios">Meus anúncios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/chatLista">Chat</a>
                    </li>
                    <li class="nav-item">
    <a id="notificacao-link" class="nav-link position-relative" href="/notificacao">
        Notificações
        <span id="notificacao-badge" class="position-absolute top-60 start-58 translate-middle-y badge rounded-pill bg-danger" style="display: none; transform: translate(-50%, -40%);">
            <span class="visually-hidden">novas notificações</span>
        </span>
    </a>
</li>

>>>>>>> develop
                </ul>

                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li class="nav-item">
<<<<<<< HEAD
                            <a class="nav-link" href="/usuario"><span class="bi bi-person"></span> <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login" style="color: orange;">Anunciar</a>
=======
                            <a class="nav-link" href="/perfilUsuario"><span class="bi bi-person"></span> <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/anunciar" style="color: orange;">Anunciar</a>
>>>>>>> develop
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

<<<<<<< HEAD
=======
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function buscarNaoVisualizadas() {
                $.ajax({
                    url: '/contarNaoVisualizadas',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log("Resposta recebida:", response); 
                        if (response.nao_visualizadas > 0) {
                            $('#notificacao-badge').text(response.nao_visualizadas).show();
                        } else {
                            $('#notificacao-badge').hide();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Erro na requisição:", textStatus, errorThrown); 
                    }
                });
            }


            buscarNaoVisualizadas();
            setInterval(buscarNaoVisualizadas, 500); 

            $('#notificacao-link').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/marcarTodasComoVisualizadas',
                    method: 'POST',
                    success: function(response) {
                        console.log("Notificações marcadas como visualizadas:", response); 
                        $('#notificacao-badge').hide(); 
                        window.location.href = '/notificacao'; 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Erro ao marcar notificações:", textStatus, errorThrown);
                    }
                });
            });
        });
    </script>

>>>>>>> develop
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
