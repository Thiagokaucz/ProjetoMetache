<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalhes do Produto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .product-image {
      width: 100%;
      max-width: 500px;
      height: 300px;
      object-fit: cover;
      border-radius: 8px;
    }
    .negociar-btn {
      background-color: #FF6B01;
      color: white;
      font-weight: bold;
      width: 100%;
    }
    .negociar-btn:hover {
      background-color: #e65b00;
    }
    .container {
      max-width: 1200px;
    }
    .product-info p {
      font-size: 0.9rem;
    }
    .valor-sugerido {
      color: #dc3545;
      font-size: 1.75rem;
      font-weight: bold;
    }
    .bordered-box {
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 1.5rem;
      margin-bottom: 1rem;
    }
    .details-title {
      color: #6c757d;
      font-size: 0.8rem;
      margin: 0;
    }
    .details-value {
      color: #FF6B01;
      font-weight: bold;
      font-size: 1rem;
    }
    .view-count {
      font-size: 0.8rem;
      color: #6c757d;
      text-align: center;
      margin-top: 0.5rem;
    }
    .related-btn {
      background-color: #007bff;
      color: white;
      font-weight: bold;
      width: 100%;
      border-radius: 8px;
    }
    .related-btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="bordered-box">
        <?php if (isset($produto)): ?>
          <img src="<?php echo $produto['locImagem']; ?>" alt="Imagem do Produto" class="img-fluid product-image mb-4">
          <h2 class="fw-bold"><?php echo htmlspecialchars($produto['titulo']); ?></h2>
          <p class="text-muted">Publicado em <?php echo date('d/m/Y H:i', strtotime($produto['dataHoraPub'])); ?></p>
          <p class="product-info"><?php echo htmlspecialchars($produto['descricao']); ?></p>

          <div class="row text-center">
            <div class="col">
              <p class="details-title">Localização</p>
              <p class="details-value"><?php echo htmlspecialchars($produto['localizacao']); ?></p>
            </div>
            <div class="col">
              <p class="details-title">Condição</p>
              <p class="details-value"><?php echo htmlspecialchars($produto['condicao']); ?></p>
            </div>
            <div class="col">
              <p class="details-title">Categoria</p>
              <p class="details-value"><?php echo htmlspecialchars($produto['nomeCategoria']); ?></p>
            </div>
          </div>
        <?php else: ?>
          <p>Produto não encontrado.</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="bordered-box text-center">
        <h4 class="mb-3">Valor sugerido:</h4>
        <p class="valor-sugerido">R$ <?php echo number_format($produto['valor'], 2, ',', '.'); ?></p>
        <?php if (!$noChat): ?>
          <button class="btn negociar-btn mt-2" 
            onclick="window.location.href='/chat?Produto=<?php echo ($produto['produtoID']); ?>&Origem=DetalhesAnuncio&Tipo=IniciarChat'">
            💬 Negociar
          </button>
          <?php endif; ?>

          <p class="view-count">Até o momento esse anúncio foi visualizado <?php echo htmlspecialchars($produto['visualizacao']); ?> vezes</p>
      </div>

      <div class="bordered-box seller-info text-center">
        <h5 class="fw-bold"><?php echo htmlspecialchars($produto['nomeAnunciante']); ?></h5>
        <p class="mt-2">Entrou no Metache em: <?php echo date('d/m/Y', strtotime($produto['dataEntradaAnunciante'])); ?></p>
      </div>

      <div class="bordered-box seller-history">
        <h5 class="fw-bold">Histórico do anunciante</h5>
        <div class="d-flex justify-content-between">
          <p class="mb-0">Vendas na plataforma:</p>
          <p class="mb-0"><?php echo number_format($totalVendas); ?></p>
        </div>
        <div class="d-flex justify-content-between mt-2">
          <p class="mb-0">Denúncias recebidas:</p>
          <p class="mb-0"><?php echo number_format($totalDenuncias); ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Link "Ver mais anúncios relacionados" no final da página -->
  <div class="text-center mt-4">
    <p>
    <a href="http://localhost/PesquisarProdutosPor?Categoria=<?php echo urlencode($produto['nomeCategoria']); ?>&Regiao=<?php echo urlencode($produto['localizacao']); ?>&Ordem=Data&Pesquisa=" 
      class="text-decoration-none fw-bold text-dark">
      Ver anúncios relacionados
    </a>
      </a>
    </p>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
