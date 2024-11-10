<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="public/img/metacheIc.ico" /> 
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
                            <span id="notificacao-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                                <span class="visually-hidden">novas notificações</span>
                            </span>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/perfilUsuario"><span class="bi bi-person"></span> <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
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

    <!-- jQuery e JavaScript para o contador de notificações -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function buscarNaoVisualizadas() {
                $.ajax({
                    url: '/contarNaoVisualizadas',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log("Resposta recebida:", response); // Exibe a resposta no console
                        if (response.nao_visualizadas > 0) {
                            $('#notificacao-badge').text(response.nao_visualizadas).show();
                        } else {
                            $('#notificacao-badge').hide();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Erro na requisição:", textStatus, errorThrown); // Exibe erros no console
                    }
                });
            }

            // Chama a função inicialmente e depois a cada 30 segundos
            buscarNaoVisualizadas();
            setInterval(buscarNaoVisualizadas, 500); // Atualiza a cada 30 segundos

            // Marcar todas como visualizadas ao clicar no link "Notificações"
            $('#notificacao-link').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/marcarTodasComoVisualizadas',
                    method: 'POST',
                    success: function(response) {
                        console.log("Notificações marcadas como visualizadas:", response); // Log de sucesso
                        $('#notificacao-badge').hide(); // Esconde o badge
                        window.location.href = '/notificacao'; // Redireciona para a página de notificações
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Erro ao marcar notificações:", textStatus, errorThrown);
                    }
                });
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
