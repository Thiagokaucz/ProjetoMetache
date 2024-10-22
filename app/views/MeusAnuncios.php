<h1>Meus Anúncios</h1>

<?php if (!empty($anuncios)): ?>
    <?php foreach ($anuncios as $anuncio): ?>
        <div class="anuncio">
            <h2>Título: <?= htmlspecialchars($anuncio['titulo']) ?></h2>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($anuncio['descricao']) ?></p>
            <p><strong>Valor:</strong> R$ <?= htmlspecialchars($anuncio['valor']) ?></p>
            <p><strong>Disponibilidade:</strong> <?= htmlspecialchars($anuncio['disponibilidade']) ?></p>
            <p><strong>Localização:</strong> <?= htmlspecialchars($anuncio['localizacao']) ?></p>
            <p><strong>Status de Aquisição:</strong> <?= htmlspecialchars($anuncio['statusAquisicao']) ?></p>

            <?php if (!empty($anuncio['acoes'])): ?>
                <p><strong>Ações:</strong></p>
                <ul>
                    <?php foreach ($anuncio['acoes'] as $acao): ?>
                        <li><?= htmlspecialchars($acao) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <!-- Link para o chat -->
            <p><a href="/chat?Produto=<?= $anuncio['produtoID'] ?>&Origem=ListaChat&Tipo=MinhasVendas">Ir para o Chat</a></p>

            <!-- Link para ver os detalhes do produto -->
            <p><a href="http://localhost/detalheProduto?id=<?= $anuncio['produtoID'] ?>">Ver Detalhes do Produto</a></p>

            <?php if ($anuncio['statusAquisicao'] === 'esperando envio' && !empty($anuncio['aquisicaoID'])): ?>
                <!-- Link para enviar o produto -->
                <p><a href="/enviarProduto?produtoID=<?= $anuncio['produtoID'] ?>&chatID=<?= $anuncio['chatID'] ?>&aquisicaoID=<?= $anuncio['aquisicaoID'] ?>">Enviar Produto</a></p>
            <?php endif; ?>

        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Você não possui anúncios cadastrados.</p>
<?php endif; ?>
