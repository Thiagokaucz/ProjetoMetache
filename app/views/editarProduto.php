<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>
<body>
    <h1>Editar Produto</h1>

    <!-- Formulário para edição de produto -->
    <form method="POST" action="">
        <label for="categoriaID">Categoria:</label>
        <input type="number" name="categoriaID" id="categoriaID" value="<?= htmlspecialchars($produto['categoriaID']) ?>" required><br>

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($produto['titulo']) ?>" required><br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required><?= htmlspecialchars($produto['descricao']) ?></textarea><br>

        <label for="valor">Valor:</label>
        <input type="text" name="valor" id="valor" value="<?= htmlspecialchars($produto['valor']) ?>" required><br>

        <label for="localizacao">Localização:</label>
        <input type="text" name="localizacao" id="localizacao" value="<?= htmlspecialchars($produto['localizacao']) ?>" required><br>

        <button type="submit">Salvar</button>
    </form>

    <a href="/meusAnuncios">Voltar</a>
</body>
</html>
