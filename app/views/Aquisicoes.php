<?php if (!empty($aquisicoes)): ?>
    <div class="container my-4 pb-3">
        <?php foreach ($aquisicoes as $aquisicao): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-body row align-items-center">
                    <!-- Data no topo -->
                    <div class="col-12 mb-3">
                        <?php
                            setlocale(LC_TIME, 'pt-BR.utf8');
                            $data = strftime("%e de %B", strtotime($aquisicao['dataHora']));
                        ?>
                        <p class="text-muted mb-0 h5"><strong><?= htmlspecialchars($data) ?></strong></p>
                    </div>

                    <!-- Imagem do Produto -->
                    <div class="col-md-3 text-center">
                        <img src="<?= htmlspecialchars($aquisicao['produto']['locImagem']) ?>" 
                             alt="Imagem do produto" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-width: 150px; height: auto; object-fit: cover;">
                    </div>

                    <!-- Informações do Produto -->
                    <div class="col-md-6">
                        <h5 class="<?= 
                            $aquisicao['statusAquisicao'] === 'pendente' ? 'text-warning' : 
                            ($aquisicao['statusAquisicao'] === 'em transporte' ? 'text-danger' : 
                            ($aquisicao['statusAquisicao'] === 'entregue' ? 'text-success' : 'text-muted')); ?>">
                            <?= htmlspecialchars($aquisicao['statusAquisicao']) ?>
                        </h5>
                        <p class="mb-1"><strong>Título:</strong> <?= htmlspecialchars($aquisicao['produto']['titulo']) ?></p>
                        <?php 
                            $valorTotalPago = htmlspecialchars($aquisicao['valorProduto']) + htmlspecialchars($aquisicao['valorFrete']);
                        ?>
                        <p class="mb-0"><strong>Valor total pago:</strong> R$ <?= number_format($valorTotalPago, 2, ',', '.') ?></p>
                    </div>

                    <!-- Ações -->
                    <div class="col-md-3 text-end">
                        <a href="chat?Produto=<?= htmlspecialchars($aquisicao['produto']['produtoID']) ?>&Origem=ListaChat&Tipo=MinhasCompras&chatID=<?= htmlspecialchars($aquisicao['chatID']) ?>" 
                           class="btn btn-primary mb-2 w-100">Enviar mensagem</a>
                        <a href="detalheProduto?id=<?= htmlspecialchars($aquisicao['produto']['produtoID']) ?>" 
                           class="btn btn-warning mb-2 w-100">Ver detalhes</a>
                        <?php if ($aquisicao['statusAquisicao'] === 'enviado'): ?>
                            <a href="receberProduto?aquisicaoID=<?= htmlspecialchars($aquisicao['aquisicaoID']) ?>" 
                               class="btn btn-success mb-2 w-100">Recebi o produto</a>
                        <?php endif; ?>
                        <?php if ($aquisicao['statusAquisicao'] === 'produto entregue'): ?>
                            <a href="/denunciarProduto?aquisicaoID=<?= htmlspecialchars($aquisicao['aquisicaoID']) ?>"

                               class="btn btn-danger w-100">Denunciar</a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Detalhes do Envio -->
                <?php if (isset($aquisicao['envio'])): ?>
                    <div class="card-footer">
                        <h6><strong>Detalhes do Envio</strong></h6>
                        <div class="row">
                            <div class="col-12 col-md-4 mb-2">
                                <p class="mb-0"><strong>Transportadora:</strong> <?= htmlspecialchars($aquisicao['envio']['transportadora']) ?></p>
                            </div>
                            <div class="col-12 col-md-4 mb-2">
                                <?php
                                    $dataHoraEnvio = new DateTime($aquisicao['envio']['dataHoraEnvio']);
                                    $dataEnvioFormatada = $dataHoraEnvio->format('d/m/Y \à\s H:i');
                                ?>
                                <p class="mb-0"><strong>Data/Hora do Envio:</strong> <?= htmlspecialchars($dataEnvioFormatada) ?></p>
                            </div>
                            <div class="col-12 col-md-4 mb-2">
                                <p class="mb-0"><strong>Código de Rastreio:</strong> <?= htmlspecialchars($aquisicao['envio']['codigoRastreio']) ?></p>
                            </div>
                            <div class="col-12">
                                <p class="mb-0"><strong>Comentário:</strong> <?= htmlspecialchars($aquisicao['envio']['comentario']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="container">
        <p class="text-center mt-5 text-muted ">Nenhuma aquisição encontrada.</p>
    </div>
<?php endif; ?>
