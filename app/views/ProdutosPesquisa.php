<?php
// Exemplo de como você pode passar dados para a view
// $produtos = resultado da busca;
// $totalProdutos = count($produtos);
// $categorias = resultado da consulta das categorias;
// $regioes = array com as regiões disponíveis
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Produtos</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Insira o caminho correto -->
</head>
<body>
    <div class="container">
        <h1>Resultados da Pesquisa</h1>
        
        <p>Total de produtos encontrados: <?php echo $totalProdutos; ?></p>

        <form method="GET" action="">
            <div class="row mb-3">
                <div class="col">
                    <label for="categoria">Categoria:</label>
                    <select name="Categoria" id="categoria" class="form-select">
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['categoria']; ?>"><?php echo $cat['categoria']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label for="regiao">Região:</label>
                    <select name="Regiao" id="regiao" class="form-select">
                        <?php foreach ($regioes as $reg): ?>
                            <option value="<?php echo $reg; ?>"><?php echo $reg; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label for="ordem">Ordenar por:</label>
                    <select name="ordem" id="ordem" class="form-select">
                        <option value="preco">Preço</option>
                        <option value="data">Data</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <h2>Produtos Encontrados</h2>
        <div class="row">
            <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="<?php echo $produto['locImagem']; ?>" class="card-img-top" alt="<?php echo $produto['titulo']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $produto['titulo']; ?></h5>
                                <p class="card-text"><?php echo $produto['descricao']; ?></p>
                                <p class="card-text">Preço: R$ <?php echo number_format($produto['valor'], 2, ',', '.'); ?></p>
                                <p class="card-text"><small class="text-muted">Publicado em: <?php echo date('d/m/Y', strtotime($produto['dataHoraPub'])); ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum produto encontrado.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="path/to/bootstrap.bundle.js"></script> <!-- Insira o caminho correto -->
</body>
</html>
