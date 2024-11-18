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
            <div class="d-flex justify-content-center" style="width: 100%; padding: 20px; background-color: #FF6B01;">
                <input type="text" class="form-control" id="campoPesquisa" placeholder="Estou procurando..." aria-label="Campo de pesquisa" style="border: none; padding: 15px; border-radius: 0; background-color: #FFF;">
                
                <div class="input-group-append">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownCategoria" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; padding: 15px; border-radius: 0; background-color: #FFF;">
                        Todos
                    </button>
                    <ul class="dropdown-menu">
                        <?php foreach ($categorias as $categoria): ?>
                            <li><a class="dropdown-item" href="#" onclick="selecionarCategoria('<?= htmlspecialchars($categoria['categoria']) ?>')"><?= htmlspecialchars($categoria['categoria']) ?></a></li>
                        <?php endforeach; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="selecionarCategoria('Todos')">Todos</a></li>
                    </ul>
                </div>

                <div class="input-group-append">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownRegiao" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; padding: 15px; border-radius: 0; background-color: #FFF;">
                        PR
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="selecionarRegiao('PR')">PR</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selecionarRegiao('SP')">SP</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selecionarRegiao('RJ')">RJ</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selecionarRegiao('MG')">MG</a></li>
                        <li><a class="dropdown-item" href="#" onclick="selecionarRegiao('RS')">RS</a></li>
                    </ul>
                </div>

                <div class="input-group-append">
                    <button class="btn btn-light" type="button" onclick="pesquisar()" style="border: none; padding: 15px; border-radius: 0; background-color: #FFF;">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
          </div>

          <script>
              let categoriaSelecionada = 'Todos';
              let regiaoSelecionada = 'PR';
              
              function selecionarCategoria(categoria) {
                  categoriaSelecionada = categoria;
                  document.getElementById('dropdownCategoria').innerText = categoria !== 'Todos' ? categoria : 'Todos';
              }

              function selecionarRegiao(regiao) {
                  regiaoSelecionada = regiao;
                  document.getElementById('dropdownRegiao').innerText = regiao;
              }

              function pesquisar() {
                  const pesquisa = document.getElementById('campoPesquisa').value;
                  const url = `/PesquisarProdutosPor?Categoria=${categoriaSelecionada}&Regiao=${regiaoSelecionada}&Ordem=Data&Pesquisa=${pesquisa}`;
                  window.location.href = url;
              }
          </script>

          <ul class="nav nav-pills mt-3">
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" style="color: white;" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Eletrônicos Usados</a>
              <ul class="dropdown-menu">
                  <?php foreach ($categorias as $categoria): ?>
                    <li><a class="dropdown-item" href="/PesquisarProdutosPor?Categoria=<?= htmlspecialchars($categoria['categoria'])?>&Regiao=PR&Ordem=Data&Pesquisa="><?= htmlspecialchars($categoria['categoria']) ?></a></li>
                    <?php endforeach; ?>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/PesquisarProdutosPor?Categoria=Todos&Regiao=PR&Pesquisa=">Todos</a></li>
              </ul>
          </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" style="color: white;" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Eletrônicos com defeito</a>
              <ul class="dropdown-menu">
                  <?php foreach ($categorias as $categoria): ?>
                    <li><a class="dropdown-item" href="/PesquisarProdutosPor?Categoria=<?= htmlspecialchars($categoria['categoria'])?>&Regiao=PR&Ordem=Data&Pesquisa="><?= htmlspecialchars($categoria['categoria']) ?></a></li>
                  <?php endforeach; ?>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/PesquisarProdutosPor?Categoria=Todos&Regiao=PR&Pesquisa=">Todos</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" style="color: white;" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Eletrônicos vintage</a>
              <ul class="dropdown-menu">
                  <?php foreach ($categorias as $categoria): ?>
                    <li><a class="dropdown-item" href="/PesquisarProdutosPor?Categoria=<?= htmlspecialchars($categoria['categoria'])?>&Regiao=PR&Ordem=Data&Pesquisa="><?= htmlspecialchars($categoria['categoria']) ?></a></li>
                  <?php endforeach; ?>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/PesquisarProdutosPor?Categoria=Todos&Regiao=PR&Ordem=Data&Pesquisa=">Todos</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link "style="color: white;" href="/PesquisarProdutosPor?Categoria=Todos&Regiao=PR&Ordem=Data&Pesquisa=">Todos</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <section class="bg-white">
    <div class="container">
      <h2 class="pt-5 pb-3">Últimos Anúncios adicionados</h2>
      <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5">

      <?php if (empty($anunciosRecentes)): ?>
        <p>Nenhum anúncio recente encontrado.</p>
      <?php else: ?>
        <?php foreach($anunciosRecentes as $anuncio): ?>
        <div class="col pb-3">
          <a href="detalheProduto?id=<?= $anuncio['produtoID'] ?>" class="text-decoration-none">
            <div class="card h-100 bg-white text-dark">
              <img src="<?= $anuncio['locImagem'] ?>" alt="Anúncio" class="card-img-top">
              <div class="card-body d-flex flex-column">
                <h4 class="card-title"><?= $anuncio['titulo'] ?></h4>
                <h6 class="card-subtitle">R$ <?= number_format($anuncio['valor'], 2, ',', '.') ?></h6>
                <div class="row mt-4">
                  <div class="col-6" style="font-size: 12px;">
                    <?= $anuncio['localizacao'] ?>
                  </div>
                  <div class="col-6 text-end" style="font-size: 12px;">
                  <?= date('d/m/Y', strtotime($anuncio['dataHoraPub'])); ?>
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
        <a class="nav-link active text-dark" aria-current="page" href="/PesquisarProdutosPor?Categoria=Todos&Regiao=PR&Ordem=Data&Pesquisa=">Ver mais</a>
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
          <a href="detalheProduto?id=<?= $anuncio['produtoID'] ?>" class="text-decoration-none">
            <div class="card h-100 bg-white text-dark">
              <img src="<?= $anuncio['locImagem'] ?>" alt="Anúncio" class="card-img-top">
              <div class="card-body d-flex flex-column">
                <h4 class="card-title"><?= $anuncio['titulo'] ?></h4>
                <h6 class="card-subtitle">R$ <?= number_format($anuncio['valor'], 2, ',', '.') ?></h6>
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
        <a class="nav-link active text-dark pb-5" aria-current="page" href="/PesquisarProdutosPor?Categoria=Todos&Regiao=PR&Ordem=Data&Pesquisa=">Ver mais</a>
      </li>
    </ul>
  </div>
</section>

</body>
</html>
