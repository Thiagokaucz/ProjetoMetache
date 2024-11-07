<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalhes do Produto</title>
  <style>
    .product-image {
      width: 100%;
      max-width: 500px;
    }
    .negociar-btn {
      background-color: #FF6B01;
      color: white;
      font-weight: bold;
    }
    .negociar-btn:hover {
      background-color: #e65b00;
    }
  </style>
</head>
<body>

<div class="fundo py-4" style="background-color: #ffffff;">
    <div class="container mt-4 mb-0">
      <div class="row align-items-center justify-content-between">
        <div class="col-md-8">
          <?php if (isset($produto)): ?>
            <img src="<?php echo $produto['locImagem']; ?>" alt="Imagem do Produto" class="img-fluid product-image mb-4">
            <h2><?php echo htmlspecialchars($produto['titulo']); ?></h2>
            <p class="text-muted">Publicado em <?php echo date('d/m/Y H:i', strtotime($produto['dataHoraPub'])); ?></p>
            <p><?php echo htmlspecialchars($produto['descricao']); ?></p>
            
            <!-- Novas informações do produto -->
            <p><strong>Condição:</strong> <?php echo htmlspecialchars($produto['condicao']); ?></p>
            <p><strong>Categoria:</strong> <?php echo htmlspecialchars($produto['nomeCategoria']); ?></p>
            <p><strong>Localização:</strong> <?php echo htmlspecialchars($produto['localizacao']); ?></p>
            <p><strong>Visualizações:</strong> <?php echo htmlspecialchars($produto['visualizacao']); ?></p>

          <?php else: ?>
            <p>Produto não encontrado.</p>
          <?php endif; ?>
        </div>

        <div class="col-md-4">
        <div class="border p-3 mb-4">
          <h4>Valor sugerido:</h4>
          <h3 class="text-danger"><?php echo 'R$ ' . number_format($produto['valor'], 2, ',', '.'); ?></h3>

          <?php if (!$noChat): ?> <!-- Exibe o botão apenas se noChat NÃO estiver presente -->
              <button class="btn negociar-btn btn-block mt-2" 
                  onclick="window.location.href='/chat?Produto=<?php echo ($produto['produtoID']); ?>&Origem=DetalhesAnuncio&Tipo=IniciarChat'">
                  💬 Negociar <?php echo ($produto['produtoID']); ?>
              </button>
          <?php endif; ?>
      </div>


          <div class="border p-3 mb-4">
            <h5><?php echo htmlspecialchars($produto['nomeAnunciante']); ?></h5>
            <p class="mt-2 text-muted">Entrou no Metache em: <?php echo date('d/m/Y', strtotime($produto['dataEntradaAnunciante'])); ?></p>
          </div>

          <div class="border p-3">
            <h5>Histórico do anunciante</h5>
            <div class="d-flex align-items-center">
              <p class="mb-0">Vendas na plataforma: <?php echo number_format($totalVendas); ?></p>
            </div>
            <div class="d-flex align-items-center mt-2">
              <p class="mb-0">Denúncias recebidas: <?php echo number_format($totalDenuncias); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

</body>
</html>
