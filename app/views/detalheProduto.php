<?php
session_start();
?>

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
          <!-- Exibição da Imagem do Produto -->
          <?php if (isset($produto)): ?>
            <img src="<?php echo $produto['locImagem']; ?>" alt="Imagem do Produto" class="img-fluid product-image mb-4">
            
            <!-- Exibição do Título do Produto -->
            <h2><?php echo $produto['titulo']; ?></h2>
            <p class="text-muted">Publicado em <?php echo date('d/m/Y H:i', strtotime($produto['dataHoraPub'])); ?></p>
            
            <!-- Descrição do Produto -->
            <p><?php echo $produto['descricao']; ?></p>
          <?php else: ?>
            <p>Produto não encontrado.</p>
          <?php endif; ?>
        </div>

        <div class="col-md-4">
          <div class="border p-3 mb-4">
            <!-- Valor do Produto -->
            <h4>Valor sugerido:</h4>
            <h3 class="text-danger"><?php echo 'R$ ' . number_format($produto['valor'], 2, ',', '.'); ?></h3>
            <button class="btn negociar-btn btn-block mt-2" onclick="window.location.href='/chat?user=<?php echo $_SESSION['user_id'];?>'">💬 Negociar</button> 
            </div>
          
          <!-- Exibição das Informações do Anunciante -->
          <div class="border p-3 mb-4">
            <h5><?php echo $produto['nomeAnunciante']; ?></h5>
            <span class="badge bg-success">Online</span>
            <p class="mt-2 text-muted">Entrou no Metache em: <?php echo date('d/m/Y', strtotime($produto['dataEntradaAnunciante'])); ?></p>
            <a href="#" class="text-decoration-none">Ver perfil do anunciante</a>
          </div>

          <div class="border p-3">
            <h5>Histórico do anunciante</h5>
            <div class="d-flex align-items-center">
              <span class="me-2" style="color: #FFA500;">★★★★☆</span>
              <p class="mb-0">Mais de 50 vendas</p>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

</body>
</html>
