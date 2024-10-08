<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
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

<div class="fundo py-4" style="background-color: #FF6B01;">
    <div class="container mt-4 mb-0">
      <!-- Stack the columns on mobile by making one full-width and the other half-width -->
      <div class="row align-items-center justify-content-between">
        <div class="col-md-8">
          <!-- Navegação com links -->
          <ul class="nav nav-pills">
            <!-- Seção de Navegação (sem alterações) -->
          </ul>
        </div>

        <div class="col-md-4">
          <!-- Search bar com dropdowns e botão -->
          <div class="input-group">
            <!-- Seção de Pesquisa (sem alterações) -->
          </div>
        </div>
      </div>
    </div>
</div>

<div class="container mt-4">
  <div class="row">
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
        <button class="btn negociar-btn btn-block mt-2">💬 Negociar</button>
      </div>
      
      <!-- Seção de Informações do Anunciante (sem alterações) -->
      <div class="border p-3 mb-4">
        <h5>Eliodoro da Cunha</h5>
        <span class="badge bg-success">Online</span>
        <p class="mt-2 text-muted">João entrou no Metache em: 25 de agosto de 2023</p>
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

<div class="container pt-3 pt-md-5"></div>

<section class=" bg-white">
    <div class="container">
      <h2 class="pt-3 pb-3">Últimos Anúncios Vistos</h2>
      <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5">
        <!-- Cards de Anúncios (sem alterações) -->
      </div>
    </div>

    <ul class="nav justify-content-center ">
      <li class="nav-item">
        <a class="nav-link active text-dark" aria-current="page" href="#">Ver mais</a>
      </li>
    </ul>

  </section>
  
  <div class="container pt-3 pt-md-5"></div>

</body>
</html>
