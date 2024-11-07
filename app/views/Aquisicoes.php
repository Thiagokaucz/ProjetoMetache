<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Aquisições</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-4 pb-3" id="aquisicoes-container">
    <?php if (!empty($aquisicoes)): ?>
        <?php foreach ($aquisicoes as $aquisicao): ?>
            <?php
                // Define a cor do status com base no status atual
                $statusClass = '';
                if ($aquisicao['statusAquisicao'] === 'pendente') $statusClass = 'text-warning';
                elseif ($aquisicao['statusAquisicao'] === 'em transporte') $statusClass = 'text-danger';
                elseif ($aquisicao['statusAquisicao'] === 'entregue') $statusClass = 'text-success';
                else $statusClass = 'text-muted';
            ?>
            <div class="card mb-4 shadow-sm aquisicao-card" data-aquisicao-id="<?= htmlspecialchars($aquisicao['aquisicaoID']) ?>">
                <div class="card-body row align-items-center">
                    <div class="col-12 mb-3">
                        <?php
                            setlocale(LC_TIME, 'pt-BR.utf8');
                            $data = strftime("%e de %B", strtotime($aquisicao['dataHora']));
                        ?>
                        <p class="text-muted mb-0 h5"><strong><?= htmlspecialchars($data) ?></strong></p>
                    </div>

                    <!-- Imagem do Produto -->
                    <div class="col-md-3 text-center">
                        <?php if (!empty($aquisicao['produto']['locImagem'])): ?>
                            <img src="<?= htmlspecialchars($aquisicao['produto']['locImagem']) ?>" 
                                 alt="Imagem do produto" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-width: 150px; height: auto; object-fit: cover;">
                        <?php else: ?>
                            <p>Imagem não disponível</p>
                        <?php endif; ?>
                    </div>

                    <!-- Informações do Produto -->
                    <div class="col-md-6">
                        <h5 class="statusAquisicao <?= $statusClass ?>" data-status="<?= htmlspecialchars($aquisicao['statusAquisicao']) ?>">
                            <?= htmlspecialchars($aquisicao['statusAquisicao']) ?>
                        </h5>
                        <p class="mb-1"><strong>Título:</strong> <?= htmlspecialchars($aquisicao['produto']['titulo'] ?? 'Título não disponível') ?></p>
                        <p class="mb-0"><strong>Valor total pago:</strong> R$ <?= number_format((float)$aquisicao['valorProduto'], 2, ',', '.') ?></p>
                        <?php
                        $produtoAquisicao = $this->aquisicoesModel->verificarProdutoEmAquisicao($aquisicao['produtoID']);
                        if ($produtoAquisicao && $produtoAquisicao['statusPagamentoVendedor'] === 'pagamento_realizado') {
                            echo "<p><strong>A plataforma já fez o pagamento para o vendedor.</strong></p>";
                        }
                        ?>
                    </div>

                    <!-- Ações -->
                    <div class="col-md-3 text-end acoes-container">
                        <?php if ($aquisicao['statusAquisicao'] === 'enviado'): ?>
                            <a href="receberProduto?aquisicaoID=<?= htmlspecialchars($aquisicao['aquisicaoID']) ?>" 
                               class="btn btn-success mb-2 w-100">Recebi o produto</a>
                        <?php elseif ($aquisicao['statusAquisicao'] === 'produto entregue'): ?>
                            <a href="/denunciarProduto?aquisicaoID=<?= htmlspecialchars($aquisicao['aquisicaoID']) ?>"
                               class="btn btn-danger mb-2 w-100">Denunciar</a>
                        <?php endif; ?>
                        <a href="chat?Produto=<?= htmlspecialchars($aquisicao['produto']['produtoID']) ?>&Origem=ListaChat&Tipo=MinhasCompras&chatID=<?= htmlspecialchars($aquisicao['chatID']) ?>" 
                           class="btn btn-primary mb-2 w-100">Enviar mensagem</a>
                        <a href="detalheProduto?id=<?= htmlspecialchars($aquisicao['produto']['produtoID']) ?>&noChat" 
                           class="btn btn-warning mb-2 w-100">Ver detalhes</a>
                    </div>
                </div>

                <!-- Detalhes do Envio -->
                <?php if ($aquisicao['statusAquisicao'] === 'enviado' && !empty($aquisicao['envio'])): ?>
                    <div class="card-footer detalhes-envio">
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
    <?php else: ?>
        <div class="container">
            <p class="text-center mt-5 text-muted">Nenhuma aquisição encontrada.</p>
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function atualizarStatusAquisicoes() {
        $.ajax({
            url: '/atualizarStatusAquisicoes',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('.aquisicao-card').each(function() {
                    var aquisicaoID = $(this).data('aquisicao-id');
                    var aquisicaoAtualizada = data.find(a => a.aquisicaoID == aquisicaoID);
                    
                    if (aquisicaoAtualizada) {
                        var statusElement = $(this).find('.statusAquisicao');
                        var novoStatus = aquisicaoAtualizada.statusAquisicao;
                        
                        if (statusElement.data('status') !== novoStatus) {
                            statusElement.data('status', novoStatus).text(novoStatus);

                            var statusClass = novoStatus === 'pendente' ? 'text-warning' :
                                              novoStatus === 'em transporte' ? 'text-danger' :
                                              novoStatus === 'entregue' ? 'text-success' : 'text-muted';
                            statusElement.attr('class', 'statusAquisicao ' + statusClass);
                            
                            var acoesContainer = $(this).find('.acoes-container');
                            var htmlAcoes = '';
                            if (novoStatus === 'enviado') {
                                htmlAcoes += `<a href="receberProduto?aquisicaoID=${aquisicaoID}" class="btn btn-success mb-2 w-100">Recebi o produto</a>`;
                            } else if (novoStatus === 'produto entregue') {
                                htmlAcoes += `<a href="/denunciarProduto?aquisicaoID=${aquisicaoID}" class="btn btn-danger w-100">Denunciar</a>`;
                            }
                            htmlAcoes += `<a href="chat?Produto=${aquisicaoAtualizada.produtoID}&Origem=ListaChat&Tipo=MinhasCompras&chatID=${aquisicaoAtualizada.chatID}" class="btn btn-primary mb-2 w-100">Enviar mensagem</a>`;
                            htmlAcoes += `<a href="detalheProduto?id=${aquisicaoAtualizada.produtoID}" class="btn btn-warning mb-2 w-100">Ver detalhes</a>`;
                            acoesContainer.html(htmlAcoes);

                            if (novoStatus === 'enviado' && aquisicaoAtualizada.envio) {
                                var detalhesEnvio = `<div class="card-footer detalhes-envio">
                                    <h6><strong>Detalhes do Envio</strong></h6>
                                    <div class="row">
                                        <div class="col-12 col-md-4 mb-2"><p class="mb-0"><strong>Transportadora:</strong> ${aquisicaoAtualizada.envio.transportadora}</p></div>
                                        <div class="col-12 col-md-4 mb-2"><p class="mb-0"><strong>Data/Hora do Envio:</strong> ${new Date(aquisicaoAtualizada.envio.dataHoraEnvio).toLocaleString('pt-BR')}</p></div>
                                        <div class="col-12 col-md-4 mb-2"><p class="mb-0"><strong>Código de Rastreio:</strong> ${aquisicaoAtualizada.envio.codigoRastreio}</p></div>
                                        <div class="col-12"><p class="mb-0"><strong>Comentário:</strong> ${aquisicaoAtualizada.envio.comentario}</p></div>
                                    </div>
                                </div>`;
                                $(this).append(detalhesEnvio);
                            } else {
                                $(this).find('.detalhes-envio').remove();
                            }
                        }
                    }
                });
            },
            error: function() {
                console.error('Erro ao atualizar os status das aquisições');
            }
        });
    }

    setInterval(atualizarStatusAquisicoes, 1000);
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
