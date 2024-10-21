<h1>Lista de Aquisições</h1>

<?php if (!empty($aquisicoes)): ?>
    <?php foreach ($aquisicoes as $aquisicao): ?>
        <div class="aquisicao">
            <h2>Aquisição ID: <?= htmlspecialchars($aquisicao['aquisicaoID']) ?></h2>
            <p><strong>Chat ID:</strong> <?= htmlspecialchars($aquisicao['chatID']) ?></p>
            <p><strong>Data/Hora:</strong> <?= htmlspecialchars($aquisicao['dataHora']) ?></p>
            <p><strong>Remetente:</strong> <?= htmlspecialchars($aquisicao['vendedorID']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($aquisicao['statusAquisicao']) ?></p>

            <h3>Detalhes do Produto</h3>
            <p><strong>Título:</strong> <?= htmlspecialchars($aquisicao['produto']['titulo']) ?></p>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($aquisicao['produto']['descricao']) ?></p>
            <p><strong>Valor:</strong> R$ <?= htmlspecialchars($aquisicao['produto']['valor']) ?></p>
            <p><strong>Localização:</strong> <?= htmlspecialchars($aquisicao['produto']['localizacao']) ?></p>
            <p><strong>Data de Publicação:</strong> <?= htmlspecialchars($aquisicao['produto']['dataHoraPub']) ?></p>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Nenhuma aquisição encontrada.</p>
<?php endif; ?>
