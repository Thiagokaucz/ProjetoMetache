<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Anúncio</title>
  <style>
    .btn-orange {
      background-color: #FF6B01; 
      color: white;
    }
    .btn-orange:hover {
      background-color: #e55b01; 
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2>Escolha os detalhes</h2>
  <form action="/criar-produto" method="POST" enctype="multipart/form-data">
    
    <div class="input-group mb-3">
      <label class="input-group-text" for="condicao">Condição:</label>
      <select class="form-select" id="condicao" name="condicao" required>
        <option value="" selected>Escolha...</option>
        <option value="Novo">Novo</option>
        <option value="Usado">Usado</option>
      </select>
    </div>

    <div class="input-group mb-3">
      <label class="input-group-text" for="categoria">Categoria:</label>
      <select class="form-select" id="categoria" name="categoria" required>
        <option value="" selected>Escolha...</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['categoriaID']; ?>"><?= $categoria['categoria']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <h2>Crie seu anúncio</h2>
    
    <div class="mb-3">
      <label for="titulo" class="form-label">Título*</label>
      <input type="text" class="form-control" id="titulo" name="titulo" required>
    </div>

    <div class="mb-3">
      <label for="marca" class="form-label">Marca*</label>
      <input type="text" class="form-control" id="marca" name="marca" required>
    </div>

    <div class="form-floating mb-3">
      <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição do item" style="height: 100px" required></textarea>
      <label for="descricao">Descrição*</label>
    </div>

    <div class="mb-3">
      <label for="valor" class="form-label">Valor*</label>
      <input type="text" class="form-control" id="valor" name="valor" required placeholder="R$ 700,00">
    </div>

    <div class="mb-3">
      <label for="localizacao" class="form-label">Localização do anúncio*</label>
      <input type="text" class="form-control" id="localizacao" name="localizacao" required placeholder="CEP">
    </div>

    <div class="mb-3">
      <label for="foto" class="form-label">Fotos do Produto</label>
      <input type="file" class="form-control" id="foto" name="foto[]" multiple required>
    </div>

    <button type="submit" class="btn btn-orange">Criar anúncio</button>
  </form>
</div>

</body>
</html>
