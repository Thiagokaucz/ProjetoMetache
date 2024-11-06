<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Produtos</title>
</head>
<body>
    <div class="container">
        <h1 class="pt-5 pb-3">Resultados da Pesquisa</h1>

        <p>Total de produtos encontrados: <strong><?php echo $totalProdutos; ?></strong></p>
        <?php if (!empty($pesquisa)): ?>
            <p>Pesquisando por: <strong><?php echo htmlspecialchars($pesquisa); ?></strong></p>
        <?php endif; ?>

        <!-- Formulário de Filtros -->
        <form method="GET" action="" class="mb-4">
            <div class="row g-4">
                <div class="col-md-3">
                    <label for="categoria" class="form-label">Categoria:</label>
                    <select name="Categoria" id="categoria" class="form-select">
                        <option value="Todos">Todos</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['categoria']; ?>" <?php if ($cat['categoria'] == $categoria) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($cat['categoria']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="regiao" class="form-label">Região:</label>
                    <select name="Regiao" id="regiao" class="form-select">
                        <?php foreach ($regioes as $reg): ?>
                            <option value="<?php echo htmlspecialchars($reg); ?>" <?php if ($reg == $regiao) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($reg); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="ordem" class="form-label">Ordenar por:</label>
                    <select name="Ordem" id="ordem" class="form-select">
                        <option value="Data" <?php if ($ordem == 'Data') echo 'selected'; ?>>Data</option>
                        <option value="Preco" <?php if ($ordem == 'Preco') echo 'selected'; ?>>Preço</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="pesquisa" class="form-label">Pesquisar:</label>
                    <input type="text" name="Pesquisa" id="pesquisa" class="form-control" value="<?php echo htmlspecialchars($pesquisa); ?>" placeholder="Digite sua pesquisa...">
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn" style="background-color: #FF6B01; color: white; padding: 10px 20px; border: none; border-radius: 5px;">
                    Buscar
                </button>
            </div>
        </form>

        <!-- Produtos encontrados -->
        <h2 class="pt-3 pb-3">Produtos Encontrados</h2>
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5">
            <?php if (empty($produtos)): ?>
                <p>Nenhum anúncio recente encontrado.</p>
            <?php else: ?>
                <?php foreach($produtos as $produto): ?>
                    <div class="col pb-3">
                        <a href="detalheProduto?id=<?= $produto['produtoID'] ?>" class="text-decoration-none">
                            <div class="card h-100 bg-white text-dark">
                                <img src="<?= $produto['locImagem'] ?>" alt="Anúncio" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title"><?= $produto['titulo'] ?></h4>
                                    <h6 class="card-subtitle">R$ <?= number_format($produto['valor'], 2, ',', '.'); ?></h6>
                                    <div class="row mt-4">
                                        <div class="col-6" style="font-size: 12px;">
                                            <?= $produto['localizacao'] ?>
                                        </div>
                                        <div class="col-6 text-end" style="font-size: 12px;">
                                            <?= date('d/m/Y', strtotime($produto['dataHoraPub'])); ?>
                                        </div>
                                        <div class="col-12" style="font-size: 12px; color: #FF6B01;">
                                            <?= $produto['condicao'] ?>
                                        </div>
                                    </div>
                                    <span class="stretched-link"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Paginação -->
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Navegação de página">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?php if ($i == $paginaAtual) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?= $i ?>&Categoria=<?= $categoria ?>&Regiao=<?= $regiao ?>&Pesquisa=<?= $pesquisa ?>&Ordem=<?= $ordem ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</body>
</html>
