<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>formulário de anúncio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .btn-orange {
      background-color: #ff6b01;
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
      color: #ff6b01;
      margin-bottom: 1.5rem;
    }
    .form-section-title {
      color: #6c757d;
      font-weight: bold;
      margin-top: 2rem;
    }
    .form-control:focus {
      border-color: #ff6b01;
      box-shadow: 0 0 5px rgba(255, 107, 1, 0.25);
    }
  </style>
</head>
<body>

<div class="container mb-5">
  <h2 class="form-title">escolha os detalhes do produto</h2>
  <form action="/criar-produto" method="post" enctype="multipart/form-data">
    
    <div class="mb-3">
      <label for="condicao" class="form-label">condição:</label>
      <select class="form-select" id="condicao" name="condicao" required>
        <option value="" selected>escolha...</option>
        <option value="Novo">novo</option>
        <option value="Usado">usado</option>
        <option value="Vintage">vintage</option>
        <option value="Com defeito">com defeito</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="categoria" class="form-label">categoria:</label>
      <select class="form-select" id="categoria" name="categoria" required>
        <option value="" selected>escolha...</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= htmlspecialchars($categoria['categoriaID']); ?>"><?= htmlspecialchars($categoria['categoria']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <h2 class="form-section-title">crie seu anúncio</h2>

    <div class="mb-3">
      <label for="titulo" class="form-label">título*</label>
      <input type="text" class="form-control" id="titulo" name="titulo" required maxlength="30">
      <small class="form-text text-muted">máximo de 30 caracteres.</small>
    </div>

    <div class="mb-3">
      <label for="marca" class="form-label">marca*</label>
      <input type="text" class="form-control" id="marca" name="marca" required>
    </div>

    <div class="mb-3">
      <label for="descricao" class="form-label">descrição*</label>
      <textarea class="form-control" id="descricao" name="descricao" placeholder="descrição do item" style="min-height: 100px" maxlength="290" required></textarea>
      <small class="form-text text-muted">insira uma breve descrição do item.</small>
    </div>

    <div class="mb-3">
      <label for="valor" class="form-label">valor*</label>
      <div class="input-group">
        <span class="input-group-text">r$</span>
        <input type="text" class="form-control" id="valor" name="valor_formatado" required placeholder="123,99">
        <input type="hidden" id="valor_oculto" name="valor">
      </div>
      <small class="form-text text-muted">insira o valor em reais (r$).</small>
    </div>

    <div class="mb-3">
      <label for="localizacao" class="form-label">estado do anúncio*</label>
      <select class="form-select" id="localizacao" name="localizacao" required>
        <option value="" disabled selected>selecione o estado</option>
        <option value="PR">pr</option>
        <option value="SP">sp</option>
        <option value="RJ">rj</option>
        <option value="MG">mg</option>
        <option value="RS">rs</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="foto" class="form-label">fotos do produto*</label>
      <input type="file" class="form-control" id="foto" name="foto[]" accept="image/*" multiple required>
      <small class="form-text text-muted">é permitido o envio de várias fotos.</small>
    </div>
    
    <div class="alert alert-success p-2">
      <small>✅ ambiente de pagamento seguro: integração com mercado pago.</small>
    </div>
    <p>caso houver dúvida, acesse <a href="/sobre?section=precificacao" class="text-dark fw-bold">como precificar meu produto</a>.</p>

    <button type="submit" class="btn btn-orange w-100">criar anúncio</button>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    $('#valor').on('input', function() {
      let value = $(this).val().replace(/\D/g, '');
      let formattedValue = (value / 100).toFixed(2).replace('.', ',');
      formattedValue = formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      $(this).val(formattedValue);
      $('#valor_oculto').val(value / 100);
    });
  });
</script>

</body>
</html>
