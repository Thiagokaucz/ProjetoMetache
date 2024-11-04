<style>
    .image-container {
        width: 150px; /* Tamanho fixo */
        height: 150px; /* Tamanho fixo */
        overflow: hidden; /* Esconde o que estiver fora do contêiner */
        display: flex;
        justify-content: center; /* Centraliza a imagem horizontalmente */
        align-items: center; /* Centraliza a imagem verticalmente */
        margin: 0 auto; /* Centraliza o contêiner na coluna */
    }

    .img-thumbnail {
    width: 100%; /* Ajusta a largura da imagem ao contêiner */
    height: auto; /* Mantém a proporção da imagem */
    display: block; /* Para remover espaço em branco abaixo da imagem */
    border: none; /* Remove a borda */
}


    .card {
        border: 1px solid #ddd; /* Bordas do cartão */
        border-radius: 8px; /* Bordas arredondadas */
    }

    .card-body {
        padding: 20px; /* Espaçamento interno do cartão */
    }

    .btn {
        margin-bottom: 10px; /* Espaçamento entre os botões */
    }
</style>

<?php if (!empty($anuncios)):
    // Verifique se existem duplicatas
    $anunciosUnicos = array_map("unserialize", array_unique(array_map("serialize", $anuncios))); ?>

    <div class="container my-4 pb-3">
        <?php // Exibir os anúncios únicos
        foreach ($anunciosUnicos as $anuncio): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-body row align-items-center">
                    <div class="col-12 mb-3">
                        <?php
                            // Definindo a localidade para português do Brasil
                            setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR.UTF-8', 'portuguese');
                            
                            // Converte a string de data para timestamp e formata a data
                            $dataTimestamp = strtotime($anuncio['dataHoraPub']);
                            $dataFormatada = strftime("%e de %B", $dataTimestamp);

                            echo '<p class="text-muted mb-0 h5"><strong>' . htmlspecialchars($dataFormatada) . '</strong></p>';
                        ?>
                    </div>

                    <div class="col-md-3 text-center">
                        <div class="image-container">
                            <img src="<?= htmlspecialchars($anuncio['locImagem']) ?>" 
                                 alt="Imagem do produto" 
                                 class="img-thumbnail">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Título:</strong> <?= htmlspecialchars($anuncio['titulo']) ?></p>
                        <p><strong>Valor:</strong> R$ <?= number_format($anuncio['valor'], 2, ',', '.') ?></p>
                        <p><strong>Disponibilidade:</strong> <?= htmlspecialchars($anuncio['disponibilidade']) ?></p>
                        <p><strong>Status de Aquisição:</strong> <?= htmlspecialchars($anuncio['statusAquisicao']) ?></p>

                        <!-- Mensagem de Pagamento -->
                        <?php
                        $aquisicao = $this->meusAnunciosModel->verificarProdutoEmAquisicao($anuncio['produtoID']);
                        if ($aquisicao) {
                            $statusPagamento = $aquisicao['statusPagamentoVendedor'];
                            switch ($statusPagamento) {
                                case 'pagamento_pendente':
                                    echo "<p><strong>A plataforma ainda não fez o pagamento.</strong></p>";
                                    break;
                                case 'pagamento_realizado':
                                    echo "<p><strong>A plataforma já fez o pagamento, aperte no link para ver o comprovante.</strong></p>";
                                    echo "<p><a href='http://localhost/comprovante?id=" . $anuncio['produtoID'] . "'>Ver Comprovante</a></p>";
                                    break;
                                case 'erro':
                                    echo "<p><strong>A plataforma entrará em contato, ocorreu algum problema.</strong></p>";
                                    break;
                            }
                        }
                        ?>

                        <!-- Verificar se o produto está em aquisição -->
                        <?php if ($anuncio['statusAquisicao'] !== 'Não está na tabela aquisição'): ?>
                            <?php 
                                $aquisicao = $this->meusAnunciosModel->obterAquisicaoPorProduto($anuncio['produtoID']);
                                $valorProduto = number_format($aquisicao['valorProduto'], 2, ',', '.');
                                $valorFrete = number_format($aquisicao['valorFrete'], 2, ',', '.');
                                $total = $aquisicao['valorProduto'] + $aquisicao['valorFrete'];
                            ?>
                            <p><strong>Valor de venda:</strong> R$ <?= number_format($total, 2, ',', '.') ?></p>
                        <?php endif; ?>
                    </div>                    

                    <div class="col-md-3 text-end">
                        <!-- Verificar se $aquisicao está definida e se o status é 'esperando envio' -->
                        <?php if (isset($aquisicao) && is_array($aquisicao) && isset($aquisicao['statusAquisicao']) && $aquisicao['statusAquisicao'] === 'esperando envio'): ?>
                            <a href="/enviarProduto?produtoID=<?= $anuncio['produtoID'] ?>&chatID=<?= $aquisicao['chatID'] ?>&aquisicaoID=<?= $aquisicao['aquisicaoID'] ?>" 
                               class="btn btn-success mb-2 w-100">Enviar Produto</a>
                        <?php endif; ?>
                        
                        <!-- Ver Detalhes do Produto -->
                        <a href="http://localhost/detalheProduto?id=<?= $anuncio['produtoID'] ?>" 
                        class="btn btn-warning mb-2 w-100">Ver Detalhes do Produto</a>

                        <!-- Link para Editar Produto -->
                        <?php if ($anuncio['disponibilidade'] === 'disponível'): ?>
                            <a href="http://localhost/editarProduto?id=<?= $anuncio['produtoID'] ?>" 
                            class="btn btn-info mb-2 w-100">Editar Produto</a>
                            <a href="http://localhost/alterarDisponibilidade?id=<?= $anuncio['produtoID'] ?>&acao=pausar" 
                               class="btn btn-secondary mb-2 w-100">Pausar Produto</a>
                        <?php elseif ($anuncio['disponibilidade'] === 'pausado'): ?>
                            <a href="http://localhost/alterarDisponibilidade?id=<?= $anuncio['produtoID'] ?>&acao=liberar" 
                               class="btn btn-success mb-2 w-100">Liberar Produto</a>
                        <?php elseif ($anuncio['statusAquisicao'] !== 'Não está na tabela aquisição' && isset($anuncio['chatID'])): ?>
                            <a href="/chat?Produto=<?= htmlspecialchars($anuncio['produtoID']) ?>&Origem=ListaChat&Tipo=MinhasVendas&chatID=<?= htmlspecialchars($anuncio['chatID']) ?>" 
                            class="btn btn-primary mb-2 w-100">Ir para o Chat</a>
                        <?php endif; ?>

                        <!-- Excluir Produto -->
                        <?php if ($anuncio['disponibilidade'] === 'disponível' || $anuncio['disponibilidade'] === 'pausado'): ?>
                            <a href="http://localhost/excluirAnuncio?id=<?= $anuncio['produtoID'] ?>" 
                               class="btn btn-danger mb-2 w-100" 
                               onclick="return confirm('Tem certeza de que deseja excluir este anúncio?')">Excluir Produto</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>

<?php else: ?>
    <p>Você não possui anúncios cadastrados.</p>
<?php endif; ?>
