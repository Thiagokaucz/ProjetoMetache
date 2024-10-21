<h1>Meus Anúncios</h1>

<?php if (!empty($anuncios)): ?>
    <?php foreach ($anuncios as $anuncio): ?>
        <div class="anuncio">
            <h2>Título: <?= htmlspecialchars($anuncio['titulo']) ?></h2>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($anuncio['descricao']) ?></p>
            <p><strong>Valor:</strong> R$ <?= htmlspecialchars($anuncio['valor']) ?></p>
            <p><strong>Disponibilidade:</strong> <?= htmlspecialchars($anuncio['condicao']) ?></p>
            <p><strong>Localização:</strong> <?= htmlspecialchars($anuncio['localizacao']) ?></p>
            <p><strong>Status de Aquisição:</strong> <?= htmlspecialchars($anuncio['statusAquisicao']) ?></p>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Você não possui anúncios cadastrados.</p>
<?php endif; ?>
