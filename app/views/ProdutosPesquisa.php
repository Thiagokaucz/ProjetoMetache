<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content-box {
            background-color: #FFFFFF;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .search-box {
            background-color: #FFFFFF;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body style="background-color: #F8F9FA;">
    <div class="container my-5">
        
        <div class="search-box">
            <h2 class="pt-3 pb-3 text-center">Encontre o que você procura</h2>
            <form method="GET" action="" class="mb-4">
                <div class="row g-3">
                    <div class="col-12 col-md-3">
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
                    <div class="col-12 col-md-3">
                        <label for="regiao" class="form-label">Região:</label>
                        <select name="Regiao" id="regiao" class="form-select">
                            <?php foreach ($regioes as $reg): ?>
                                <option value="<?php echo htmlspecialchars($reg); ?>" <?php if ($reg == $regiao) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($reg); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="ordem" class="form-label">Ordenar por:</label>
                        <select name="Ordem" id="ordem" class="form-select">
                            <option value="Data" <?php if ($ordem == 'Data') echo 'selected'; ?>>Data</option>
                            <option value="Preco" <?php if ($ordem == 'Preco') echo 'selected'; ?>>Preço</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="pesquisa" class="form-label">Pesquisar:</label>
                        <input type="text" name="Pesquisa" id="pesquisa" class="form-control" value="<?php echo htmlspecialchars($pesquisa); ?>" placeholder="Digite sua pesquisa...">
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary px-5 py-2" style="background-color: #FF6B01; color: white; border: none; border-radius: 5px; width: 100%; max-width: 400px;">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
        
        <div class="content-box">
            <h2 class="pt-3 pb-3 text-center">Resultados da Pesquisa</h2>

            <p class="text-center">Total de produtos encontrados: <strong><?php echo $totalProdutos; ?></strong></p>
            <?php if (!empty($pesquisa)): ?>
                <p class="text-center">Pesquisando por: <strong><?php echo htmlspecialchars($pesquisa); ?></strong></p>
            <?php endif; ?>

            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-3">
                <?php if (empty($produtos)): ?>
                    <p class="text-center">Nenhum anúncio recente encontrado.</p>
                <?php else: ?>
                    <?php foreach($produtos as $produto): ?>
                        <div class="col">
                            <a href="detalheProduto?id=<?= $produto['produtoID'] ?>" class="text-decoration-none">
                                <div class="card h-100 shadow-sm">
                                    <img src="<?= $produto['locImagem'] ?>" alt="Anúncio" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h4 class="card-title"><?= $produto['titulo'] ?></h4>
                                        <h6 class="card-subtitle">R$ <?= number_format($produto['valor'], 2, ',', '.'); ?></h6>
                                        <div class="row mt-3">
                                            <div class="col-6" style="font-size: 12px;">
                                                <?= $produto['localizacao'] ?>
                                            </div>
                                            <div class="col-6 text-end" style="font-size: 12px;">
                                                <?= date('d/m/Y', strtotime($produto['dataHoraPub'])); ?>
                                            </div>
                                            <div class="col-12 mt-1" style="font-size: 12px; color: #FF6B01;">
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
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Navegação de página">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?php if ($i == $paginaAtual) echo 'active'; ?>">
                                <a class="page-link" style="background-color: <?php echo ($i == $paginaAtual) ? '#FF6B01' : '#FFF'; ?>; color: <?php echo ($i == $paginaAtual) ? '#FFF' : '#FF6B01'; ?>; border: none; border-radius: 5px;" href="?page=<?= $i ?>&Categoria=<?= $categoria ?>&Regiao=<?= $regiao ?>&Pesquisa=<?= $pesquisa ?>&Ordem=<?= $ordem ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
