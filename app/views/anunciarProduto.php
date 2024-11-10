<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Anúncio</title>
  <!-- Bootstrap CSS -->
  <style>
    .btn-orange {
      background-color: #FF6B01; 
      color: white;
    }
    .btn-orange:hover {
      background-color: #e55b01; 
    }
    body {
      background-color: #f8f9fa; /* Cor de fundo suave */
    }
    .container {
      margin-top: 30px; /* Espaçamento no topo */
      background: white; /* Fundo branco para o formulário */
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
    }
  </style>
</head>
<body>

<div class="container">
  <h2 class="mb-4">Escolha os detalhes</h2>
  <form action="/criar-produto" method="POST" enctype="multipart/form-data">
    
    <div class="mb-3">
      <label for="condicao" class="form-label">Condição:</label>
      <select class="form-select" id="condicao" name="condicao" required>
        <option value="" selected>Escolha...</option>
        <option value="Novo">Novo</option>
        <option value="Usado">Usado</option>
        <option value="Vintage">Vintage</option>
        <option value="Com defeito">Com defeito</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="categoria" class="form-label">Categoria:</label>
      <select class="form-select" id="categoria" name="categoria" required>
        <option value="" selected>Escolha...</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= htmlspecialchars($categoria['categoriaID']); ?>"><?= htmlspecialchars($categoria['categoria']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <h2 class="mt-4">Crie seu anúncio</h2>
    
    <div class="mb-3">
      <label for="titulo" class="form-label">Título*</label>
      <input type="text" class="form-control" id="titulo" name="titulo" required maxlength="30">
      <small class="form-text text-muted">Máximo de 30 caracteres.</small>
    </div>


    <div class="mb-3">
      <label for="marca" class="form-label">Marca*</label>
      <input type="text" class="form-control" id="marca" name="marca" required>
    </div>

    <div class="mb-3">
      <label for="descricao" class="form-label">Descrição*</label>
      <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição do item" style="min-height: 100px" required></textarea>
      <small class="form-text text-muted">Insira uma breve descrição do item.</small>
    </div>


    <div class="mb-3">
      <label for="valor" class="form-label">Valor*</label>
      <input type="number" class="form-control" id="valor" name="valor" required min="0" step="0.01" placeholder="700,00">
      <small class="form-text text-muted">Insira o valor em reais (R$).</small>
    </div>

    <div class="mb-3">
      <label for="localizacao" class="form-label">Estado do anúncio*</label>
      <select class="form-select" id="localizacao" name="localizacao" required>
        <option value="" disabled selected>Selecione o estado</option>
        <option value="PR">PR</option>
        <option value="SP">SP</option>
        <option value="RJ">RJ</option>
        <option value="MG">MG</option>
        <option value="RS">RS</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="foto" class="form-label">Fotos do Produto*</label>
      <input type="file" class="form-control" id="foto" name="foto[]" accept="image/*" multiple required>
    </div>
    
    <div class="alert alert-info p-2">
        <small>💳 A plataforma utiliza integração com Mercado Pago.</small>
    </div>
        Caso ouver duvida, acesse <a href="/sobre?section=precificacao ">Como comprar com Metache</a><p>    

    <button type="submit" class="btn btn-orange">Criar Anúncio</button>
  </form>

  <!-- Espaço no final -->
</div>
  <div class="mt-4"></div>

<!-- Bootstrap JS (Opcional) -->
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
