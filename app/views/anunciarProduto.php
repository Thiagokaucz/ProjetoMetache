<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Anúncio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .btn-orange {
      background-color: #FF6B01;
      color: white;
    }
    .btn-orange:hover {
      background-color: #e55b01;
    }
    body {
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 30px;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .form-title {
      font-weight: bold;
      color: #FF6B01;
      margin-bottom: 1.5rem;
    }
    .form-section-title {
      color: #6c757d;
      font-weight: bold;
      margin-top: 2rem;
    }
    .form-control:focus {
      border-color: #FF6B01;
      box-shadow: 0 0 5px rgba(255, 107, 1, 0.25);
    }
  </style>
</head>
<body>

<div class="container mb-5">
  <h2 class="form-title">Escolha os Detalhes do Produto</h2>
  <form action="/criar-produto" method="POST" enctype="multipart/form-data">
    
    <!-- Condição do Produto -->
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

    <!-- Categoria do Produto -->
    <div class="mb-3">
      <label for="categoria" class="form-label">Categoria:</label>
      <select class="form-select" id="categoria" name="categoria" required>
        <option value="" selected>Escolha...</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= htmlspecialchars($categoria['categoriaID']); ?>"><?= htmlspecialchars($categoria['categoria']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <h2 class="form-section-title">Crie Seu Anúncio</h2>

    <!-- Título do Anúncio -->
    <div class="mb-3">
      <label for="titulo" class="form-label">Título*</label>
      <input type="text" class="form-control" id="titulo" name="titulo" required maxlength="30">
      <small class="form-text text-muted">Máximo de 30 caracteres.</small>
    </div>

    <!-- Marca do Produto -->
    <div class="mb-3">
      <label for="marca" class="form-label">Marca*</label>
      <input type="text" class="form-control" id="marca" name="marca" required>
    </div>

    <!-- Descrição do Produto -->
    <div class="mb-3">
      <label for="descricao" class="form-label">Descrição*</label>
      <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição do item" style="min-height: 100px" required></textarea>
      <small class="form-text text-muted">Insira uma breve descrição do item.</small>
    </div>

    <!-- Valor do Produto -->
    <div class="mb-3">
  <label for="valor" class="form-label">Valor*</label>
  <div class="input-group">
    <span class="input-group-text">R$</span>
    <input type="text" class="form-control" id="valor" name="valor_formatado" required placeholder="700,00">
    <input type="hidden" id="valor_oculto" name="valor">
  </div>
  <small class="form-text text-muted">Insira o valor em reais (R$).</small>
</div>


    <!-- Localização -->
    <div class="mb-3">
      <label for="localizacao" class="form-label">Estado do Anúncio*</label>
      <select class="form-select" id="localizacao" name="localizacao" required>
        <option value="" disabled selected>Selecione o estado</option>
        <option value="PR">PR</option>
        <option value="SP">SP</option>
        <option value="RJ">RJ</option>
        <option value="MG">MG</option>
        <option value="RS">RS</option>
      </select>
    </div>

    <!-- Upload de Fotos -->
    <div class="mb-3">
      <label for="foto" class="form-label">Fotos do Produto*</label>
      <input type="file" class="form-control" id="foto" name="foto[]" accept="image/*" multiple required>
      <small class="form-text text-muted">É permitido o envio de várias fotos.</small>
    </div>
    
    <!-- Informativo Mercado Pago -->
    <div class="alert alert-success p-2">
      <small>✅ A plataforma utiliza integração com Mercado Pago.</small>
    </div>
    <p class="">Caso houver dúvida, acesse <a href="/sobre?section=precificacao" class="text-dark fw-bold">Como precificar meu produto</a>.</p>


    <!-- Botão de Envio -->
    <button type="submit" class="btn btn-orange w-100">Criar Anúncio</button>
  </form>

  <div class="mt-4"></div>
</div>

<!-- Bootstrap JS e jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Formatação do campo de valor para moeda
  $(document).ready(function() {
  $('#valor').on('input', function() {
    let value = $(this).val().replace(/\D/g, ''); // Remove tudo que não for número
    let formattedValue = (value / 100).toFixed(2).replace('.', ','); // Formata com vírgula
    formattedValue = formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Insere ponto a cada milhar
    $(this).val(formattedValue); // Atualiza o campo com a formatação correta
    
    $('#valor_oculto').val(value / 100); // Envia o valor bruto para o campo oculto
  });
});

</script>

</body>
</html>
