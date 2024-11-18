<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            background-color: #FF6B01;
            color: white;
        }
        .btn-custom:hover {
            background-color: #e55b01;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <h1 class="mb-4">Editar Produto</h1>

        <form method="POST" action="" class="border p-4 rounded shadow">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" name="titulo" id="titulo" class="form-control" value="<?= htmlspecialchars($produto['titulo']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea name="descricao" id="descricao" class="form-control" required><?= htmlspecialchars($produto['descricao']) ?></textarea>
            </div>

            <div class="mb-3">
    <label for="valor" class="form-label">Valor:</label>
    <div class="input-group">
        <span class="input-group-text">R$</span>
        <input type="text" name="valor_formatado" id="valor" class="form-control" value="<?= htmlspecialchars(number_format($produto['valor'], 2, ',', '.')) ?>" required>
        <input type="hidden" name="valor" id="valor_oculto" value="<?= htmlspecialchars($produto['valor']) ?>">
    </div>
</div>


            <button type="submit" class="btn btn-custom">Salvar</button>
            <a href="/meusAnuncios" class="btn btn-secondary">Voltar</a>
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
