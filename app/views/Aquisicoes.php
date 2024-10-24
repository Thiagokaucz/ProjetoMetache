<?php if (!empty($aquisicoes)): ?>
    <?php foreach ($aquisicoes as $aquisicao): ?>
        <div class="aquisicao">
            <h2>Aquisição ID: <?= htmlspecialchars($aquisicao['aquisicaoID']) ?></h2>
            <p><strong>Chat ID:</strong> <?= htmlspecialchars($aquisicao['chatID']) ?></p>
            <p><strong>Data/Hora:</strong> <?= htmlspecialchars($aquisicao['dataHora']) ?></p>
            <p><strong>Remetente:</strong> <?= htmlspecialchars($aquisicao['vendedorID']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($aquisicao['statusAquisicao']) ?></p>
            <p><strong>Valor pago:</strong> <?= htmlspecialchars($aquisicao['valorProduto']) ?></p>
            <p><strong>Frete pago:</strong> <?= htmlspecialchars($aquisicao['valorFrete']) ?></p>

            <h3>Detalhes do Produto</h3>
            <p><strong>Título:</strong> <?= htmlspecialchars($aquisicao['produto']['titulo']) ?></p>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($aquisicao['produto']['descricao']) ?></p>
            <p><strong>Valor do anúncio:</strong> R$ <?= htmlspecialchars($aquisicao['produto']['valor']) ?></p>
            <p><strong>Localização:</strong> <?= htmlspecialchars($aquisicao['produto']['localizacao']) ?></p>
            <p><strong>Data de Publicação:</strong> <?= htmlspecialchars($aquisicao['produto']['dataHoraPub']) ?></p>

            <p><a href="detalheProduto?id=<?= htmlspecialchars($aquisicao['produto']['produtoID']) ?>">Detalhes do produto</a></p>

            <p><a href="chat?Produto=<?= htmlspecialchars($aquisicao['produto']['produtoID']) ?>&Origem=ListaChat&Tipo=MinhasCompras&chatID=<?= htmlspecialchars($aquisicao['chatID']) ?>">Chat</a></p>

            <?php if (isset($aquisicao['envio'])): ?>
                <h3>Detalhes do Envio</h3>
                <p><strong>Transportadora:</strong> <?= htmlspecialchars($aquisicao['envio']['transportadora']) ?></p>
                <p><strong>Data/Hora do Envio:</strong> <?= htmlspecialchars($aquisicao['envio']['dataHoraEnvio']) ?></p>
                <p><strong>Código de Rastreio:</strong> <?= htmlspecialchars($aquisicao['envio']['codigoRastreio']) ?></p>
                <p><strong>Comentário:</strong> <?= htmlspecialchars($aquisicao['envio']['comentario']) ?></p>
            <?php endif; ?>

            <!-- Link "Recebi o produto" -->
            <?php if ($aquisicao['statusAquisicao'] === 'finalizado'): ?>
                <p>
                    <a href="receberProduto?aquisicaoID=<?= htmlspecialchars($aquisicao['aquisicaoID']) ?>">Recebi o produto</a>
                </p>
            <?php endif; ?>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Nenhuma aquisição encontrada.</p>
<?php endif; ?>
