<head>
  <title>Home</title>
  <style>
    .card-img-top {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
  </style>
</head>

<body>

<div class="fundo py-4" style="background-color: #FF6B01;">
  <div class="container mt-4 mb-0">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="input-group">
          <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            PR
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">PR</a></li>
            <li><a class="dropdown-item" href="#">SP</a></li>
            <li><a class="dropdown-item" href="#">RJ</a></li>
            <li><a class="dropdown-item" href="#">MG</a></li>
            <li><a class="dropdown-item" href="#">RS</a></li>
          </ul>
          
          <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Eletrônicos
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Eletrônicos</a></li>
            <li><a class="dropdown-item" href="#">Imóveis</a></li>
            <li><a class="dropdown-item" href="#">Veículos</a></li>
            <li><a class="dropdown-item" href="#">Móveis</a></li>
            <li><a class="dropdown-item" href="#">Roupas</a></li>
          </ul>

          <input type="text" class="form-control" placeholder="Estou procurando por..." aria-label="Campo de pesquisa">
          
          <button class="btn btn-light" type="button">
            <i class="bi bi-search"></i>
          </button>
        </div>

        <ul class="nav nav-pills mt-3">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" style="color: white;" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Eletronicos usados</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
          </li>
          <!-- Repetir para outras categorias -->
        </ul>
      </div>
    </div>
  </div>
</div>

<section class="bg-white">
  <div class="container">
    <h2 class="pt-3 pb-3">Últimos Anúncios Vistos</h2>
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5">
      <?php if (empty($anunciosRecentes)): ?>
        <p>Nenhum anúncio recente encontrado.</p>
      <?php else: ?>
        <?php foreach($anunciosRecentes as $anuncio): ?>
        <div class="col pb-3">
          <a href="anuncio.php?id=<?= $anuncio['produtoID'] ?>" class="text-decoration-none">
            <div class="card h-80 bg-white text-dark">
              <img src="<?= $anuncio['locImagem'] ?>" alt="Anúncio" class="card-img-top">
              <div class="card-body">
                <h4 class="card-title"><?= $anuncio['titulo'] ?></h4>
                <h6 class="card-subtitle">R$ <?= $anuncio['valor'] ?></h6>
                <div class="row mt-4">
                  <div class="col-6" style="font-size: 12px;">
                    <?= $anuncio['localizacao'] ?>
                  </div>
                  <div class="col-6 text-end" style="font-size: 12px;">
                    <?= $anuncio['dataHoraPub'] ?>
                  </div>
                  <div class="col-12" style="font-size: 12px; color: #FF6B01;">
                    <?= $anuncio['condicao'] ?>
                  </div>
                </div>
                <span class="stretched-link"></span>
              </div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <ul class="nav justify-content-center">
      <li class="nav-item">
        <a class="nav-link active text-dark" aria-current="page" href="#">Ver mais</a>
      </li>
    </ul>
  </div>
</section>

<section class="bg-white">
  <div class="container">
    <h2 class="pt-3 pb-3">Mais Pesquisados</h2>
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5">
      <?php if (empty($maisPesquisados)): ?>
        <p>Nenhum anúncio encontrado para "mais pesquisados".</p>
      <?php else: ?>
        <?php foreach($maisPesquisados as $anuncio): ?>
        <div class="col pb-3">
          <a href="anuncio.php?id=<?= $anuncio['produtoID'] ?>" class="text-decoration-none">
            <div class="card h-80 bg-white text-dark">
              <img src="<?= $anuncio['locImagem'] ?>" alt="Anúncio" class="card-img-top">
              <div class="card-body">
                <h4 class="card-title"><?= $anuncio['titulo'] ?></h4>
                <h6 class="card-subtitle">R$ <?= $anuncio['valor'] ?></h6>
                <div class="row mt-4">
                  <div class="col-6" style="font-size: 12px;">
                    <?= $anuncio['localizacao'] ?>
                  </div>
                  <div class="col-6 text-end" style="font-size: 12px;">
                    <?= $anuncio['dataHoraPub'] ?>
                  </div>
                  <div class="col-12" style="font-size: 12px; color: #FF6B01;">
                    <?= $anuncio['condicao'] ?>
                  </div>
                </div>
                <span class="stretched-link"></span>
              </div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

</body>
</html>
