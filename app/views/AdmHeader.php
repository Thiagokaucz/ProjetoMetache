<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body style="background-color: #f0f0f5;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/homeadm">
                <img src="public/img/Metache.png" alt="logo" height="25" width="auto">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/ListPagamentosAdm">pagamentos vendas pendentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/comprasFinalizadasCanceladas">vendas finalizadas</a>
                    </li>
                    <?php if ($_SESSION['cargo'] === 'gerente'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admcadastrarusuario">cadastrar funcionários</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link">
                            <span class="bi bi-person"></span>
                            <?php 
                                echo htmlspecialchars($_SESSION['admin_name']); 
                                echo " - conta de " . ($_SESSION['cargo'] === 'gerente' ? 'gerente' : 'funcionário'); 
                            ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admlogout" style="color: red;">
                            <span class="bi bi-box-arrow-right"></span> sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
