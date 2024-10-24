<h1>Meus Anúncios</h1>

<?php
// Verifique se há anúncios
if (!empty($anuncios)):
    // Verifique se existem duplicatas
    $anunciosUnicos = array_map("unserialize", array_unique(array_map("serialize", $anuncios)));

    // Exibir os anúncios únicos
    foreach ($anunciosUnicos as $anuncio): ?>
        <div class="anuncio">
        <h2>Título: <?= htmlspecialchars($anuncio['titulo']) ?></h2>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($anuncio['descricao']) ?></p>
            <p><strong>Valor:</strong> R$ <?= number_format($anuncio['valor'], 2, ',', '.') ?></p>
            <p><strong>Disponibilidade:</strong> <?= htmlspecialchars($anuncio['disponibilidade']) ?></p>
            <p><strong>Localização:</strong> <?= htmlspecialchars($anuncio['localizacao']) ?></p>
            <p><strong>Status de Aquisição:</strong> <?= htmlspecialchars($anuncio['statusAquisicao']) ?></p>

            <!-- Ver Detalhes do Produto -->
            <p><a href="http://localhost/detalheProduto?id=<?= $anuncio['produtoID'] ?>">Ver Detalhes do Produto</a></p>

            <!-- Se o produto estiver em aquisição -->
            <?php if ($anuncio['statusAquisicao'] !== 'Não está na tabela aquisição' && isset($anuncio['chatID'])): ?>
                <p>
                    <a href="/chat?Produto=<?= htmlspecialchars($anuncio['produtoID']) ?>&Origem=ListaChat&Tipo=MinhasVendas&chatID=<?= htmlspecialchars($anuncio['chatID']) ?>">
                        Ir para o Chat
                    </a>
                </p>
            <?php endif; ?>

            <!-- Verificar se o produto está em aquisição e atribuir a variável $aquisicao -->
            <?php if ($anuncio['statusAquisicao'] !== 'Não está na tabela aquisição'): ?>
                <?php 
                    // Aqui você deve buscar a aquisições se necessário.
                    // Exemplo (supondo que você tenha uma função que busca isso):
                    $aquisicao = $this->meusAnunciosModel->obterAquisicaoPorProduto($anuncio['produtoID']); 
                ?>
                
                <!-- Se o status de aquisição for esperando envio -->
                <?php if (isset($aquisicao) && $aquisicao['statusAquisicao'] === 'esperando envio'): ?>
                    <p><a href="/enviarProduto?produtoID=<?= $anuncio['produtoID'] ?>&chatID=<?= $aquisicao['chatID'] ?>&aquisicaoID=<?= $aquisicao['aquisicaoID'] ?>">Enviar Produto</a></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Você não possui anúncios cadastrados.</p>
<?php endif; ?>
