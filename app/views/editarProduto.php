<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <!-- Bootstrap CSS -->
    <style>
        .btn-custom {
            background-color: #FF6B01;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <h1 class="mb-4">Editar Produto</h1>

        <!-- Formulário para edição de produto -->
        <form method="POST" action="" class="border p-4 rounded shadow">
            <div class="mb-3">
                <label for="categoriaID" class="form-label">Categoria:</label>
                <input type="number" name="categoriaID" id="categoriaID" class="form-control" value="<?= htmlspecialchars($produto['categoriaID']) ?>" required>
            </div>

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
                <input type="text" name="valor" id="valor" class="form-control" value="<?= htmlspecialchars($produto['valor']) ?>" required>
            </div>

            <button type="submit" class="btn btn-custom">Salvar</button>
            <a href="/meusAnuncios" class="btn btn-secondary">Voltar</a>
        </form>
    </div>

    <!-- Bootstrap JS (Opcional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
