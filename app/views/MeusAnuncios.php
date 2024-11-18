<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus anúncios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-4 pb-3" id="meusanuncios-container">

<?php if (!empty($anuncios)):

$anunciosUnicos = array_map("unserialize", array_unique(array_map("serialize", $anuncios))); ?>



    <?php
    foreach ($anunciosUnicos as $anuncio): ?>
        <div class="card mb-4 shadow-sm aquisicao-card">
            <div class="card-body row align-items-center">
                <div class="col-12 mb-3">
                    <?php

                    setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR.UTF-8', 'portuguese');
                        
                    $dataTimestamp = strtotime($anuncio['dataHoraPub']);
                    $dataFormatada = strftime("%e de %B", $dataTimestamp);

                    ?>
                    <p class="text-muted mb-0 h5"><strong><?= htmlspecialchars($dataFormatada) ?></strong></p>
                </div>

                <div class="col-md-3 text-center">
                    <img src="<?= htmlspecialchars($anuncio['locImagem']) ?>" 
                         alt="Imagem do produto" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-width: 150px; height: auto; object-fit: cover;">
                </div>

                <div class="col-md-6">
<?php
$statusFormatado = ucwords(str_replace('_', ' ', $anuncio['statusAquisicao']));
?>

<h5 class="statusAquisicao <?= $statusClass ?>" data-status="<?= htmlspecialchars($anuncio['statusAquisicao']) ?>">
    <?= htmlspecialchars($statusFormatado) ?>
</h5>


                    <p><strong>Título:</strong> <?= htmlspecialchars($anuncio['titulo']) ?></p>
                    <p><strong>Valor do anuncio:</strong> R$ <?= number_format($anuncio['valor'], 2, ',', '.') ?></p>

                    
                    
                    <?php if ($anuncio['statusAquisicao'] !== 'Anunciado'): ?>
                        <?php 
                            $aquisicao = $this->meusAnunciosModel->obterAquisicaoPorProduto($anuncio['produtoID']);
                            $total = $aquisicao['valorProduto'];
                        ?>
                        <p><strong>Valor de venda:</strong> R$ <?= number_format($total, 2, ',', '.') ?></p>
                    <?php endif; ?>

                    <?php if ($anuncio['statusAquisicao'] == 'produto entregue'):

                        $aquisicao = $this->meusAnunciosModel->verificarProdutoEmAquisicao($anuncio['produtoID']);
                        if ($aquisicao) {
                            $statusPagamento = $aquisicao['statusPagamentoVendedor'];
                            switch ($statusPagamento) {
                                case 'pagamento_pendente':
                                    echo "<p><strong>Em breve a plataforma realizara o pagamento.</strong></p>";
                                    break;
                                case 'pagamento_realizado':
                                    echo "<p><strong>A plataforma já fez o pagamento.</strong></p>";
echo "<p><a href='/comprovante?id=" . htmlspecialchars($anuncio['produtoID']) . "' class='btn btn-outline-info d-inline-flex align-items-center'><i class='bi bi-file-earmark-text me-2'></i> Ver comprovantes</a></p>";
                                    break;
                                case 'erro':
                                    echo "<p><strong>A plataforma entrará em contato, ocorreu algum problema.</strong></p>";
                                    break;
                            }
                        }
                        endif; 
                    ?>
                    
                </div>                    

                <div class="col-md-3 text-end acoes-container">
                <?php if (isset($aquisicao) && is_array($aquisicao) && isset($aquisicao['statusAquisicao']) && $aquisicao['statusAquisicao'] === 'esperando envio' && $anuncio['disponibilidade'] !== 'disponível' && $anuncio['disponibilidade'] !== 'pausado'): ?>
                    <a href="/enviarProduto?produtoID=<?= $anuncio['produtoID'] ?>&chatID=<?= $aquisicao['chatID'] ?>&aquisicaoID=<?= $aquisicao['aquisicaoID'] ?>" 
                    class="btn btn-success mb-2 w-100">Enviar Produto</a>
                <?php endif; ?>
                    
                    <a href="/detalheProduto?id=<?= $anuncio['produtoID'] ?>&noChat" 
                    class="btn btn-warning mb-2 w-100">Ver Detalhes do Produto</a>

                    <?php if ($anuncio['disponibilidade'] === 'disponível'): ?>
                        <a href="/editarProduto?id=<?= $anuncio['produtoID'] ?>" 
                        class="btn btn-info mb-2 w-100">Editar Produto</a>
                        <a href="/alterarDisponibilidade?id=<?= $anuncio['produtoID'] ?>&acao=pausar" 
                           class="btn btn-secondary mb-2 w-100">Pausar Produto</a>
                    <?php elseif ($anuncio['disponibilidade'] === 'pausado'): ?>
                        <a href="/alterarDisponibilidade?id=<?= $anuncio['produtoID'] ?>&acao=liberar" 
                           class="btn btn-success mb-2 w-100">Liberar Produto</a>
                    <?php elseif ($anuncio['statusAquisicao'] !== 'Não está na tabela aquisição' && isset($anuncio['chatID'])): ?>
                        <a href="/chat?Produto=<?= htmlspecialchars($anuncio['produtoID']) ?>&Origem=ListaChat&Tipo=MinhasVendas&chatID=<?= htmlspecialchars($anuncio['chatID']) ?>" 
                        class="btn btn-primary mb-2 w-100">Ir para o Chat</a>
                    <?php endif; ?>

                    <?php if ($anuncio['disponibilidade'] === 'disponível' || $anuncio['disponibilidade'] === 'pausado'): ?>
                        <a href="/excluirAnuncio?id=<?= $anuncio['produtoID'] ?>" 
                           class="btn btn-danger mb-2 w-100" 
                           onclick="return confirm('Tem certeza de que deseja excluir este anúncio?')">Excluir Produto</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <hr>
    <?php endforeach; ?>

<?php else: ?>
    <p class="text-center mt-5 text-muted">Você não possui anúncios cadastrados.</p>
<?php endif; ?>
</div>
</body>
</html>
