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

            <!-- Mensagem de Pagamento -->
            <?php
            $aquisicao = $this->meusAnunciosModel->verificarProdutoEmAquisicao($anuncio['produtoID']);
            if ($aquisicao) {
                $statusPagamento = $aquisicao['statusPagamentoVendedor'];
                if ($statusPagamento === 'pagamento_pendente') {
                    echo "<p><strong>A plataforma ainda não fez o pagamento.</strong></p>";
                } elseif ($statusPagamento === 'pagamento_realizado') {
                    echo "<p><strong>A plataforma já fez o pagamento, aperte no link para ver o comprovante.</strong></p>";
                    // Aqui você pode adicionar um link para o comprovante, se disponível
                    echo "<p><a href='http://localhost/comprovante?id=" . $anuncio['produtoID'] . "'>Ver Comprovante</a></p>";
                } elseif ($statusPagamento === 'erro') {
                    echo "<p><strong>A plataforma entrará em contato, ocorreu algum problema.</strong></p>";
                }
            }
            ?>

                        <!-- Verificar se o produto está em aquisição e atribuir a variável $aquisicao -->
                        <?php if ($anuncio['statusAquisicao'] !== 'Não está na tabela aquisição'): ?>
                <?php 
                    // Aqui você deve buscar as aquisições se necessário.
                    // Exemplo (supondo que você tenha uma função que busca isso):
                    $aquisicao = $this->meusAnunciosModel->obterAquisicaoPorProduto($anuncio['produtoID']); // isso é gambi
                    echo ('Valor do Produto: R$ ' . number_format($aquisicao['valorProduto'], 2, ',', '.') . '<br>');
                    echo ('Valor do Frete: R$ ' . number_format($aquisicao['valorFrete'], 2, ',', '.') . '<br>');
                    
                    // Calcular o total
                    $total = $aquisicao['valorProduto'] + $aquisicao['valorFrete'];
                    
                    // Exibir o total
                    echo ('<strong>Total: R$ ' . number_format($total, 2, ',', '.') . '</strong><br>');
                    

                ?>
                
                <!-- Se o status de aquisição for esperando envio -->
                <?php if (isset($aquisicao) && $aquisicao['statusAquisicao'] === 'esperando envio'): ?>
                    <p><a href="/enviarProduto?produtoID=<?= $anuncio['produtoID'] ?>&chatID=<?= $aquisicao['chatID'] ?>&aquisicaoID=<?= $aquisicao['aquisicaoID'] ?>">Enviar Produto</a></p>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Ver Detalhes do Produto -->
            <p><a href="http://localhost/detalheProduto?id=<?= $anuncio['produtoID'] ?>">Ver Detalhes do Produto</a></p>

            <!-- Link para Editar Produto, visível apenas se disponibilidade for 'disponível' -->
            <?php if ($anuncio['disponibilidade'] === 'disponível'): ?>
                <p><a href="http://localhost/editarProduto?id=<?= $anuncio['produtoID'] ?>">Editar Produto</a></p>
                <!-- Opção para Pausar -->
                <p><a href="http://localhost/alterarDisponibilidade?id=<?= $anuncio['produtoID'] ?>&acao=pausar">Pausar Produto</a></p>
            <?php elseif ($anuncio['disponibilidade'] === 'pausado'): ?>
                <!-- Opção para Liberar -->
                <p><a href="http://localhost/alterarDisponibilidade?id=<?= $anuncio['produtoID'] ?>&acao=liberar">Liberar Produto</a></p>
            <?php endif; ?>

            <!-- Se o produto estiver em aquisição -->
            <?php if ($anuncio['statusAquisicao'] !== 'Não está na tabela aquisição' && isset($anuncio['chatID'])): ?>
                <p>
                    <a href="/chat?Produto=<?= htmlspecialchars($anuncio['produtoID']) ?>&Origem=ListaChat&Tipo=MinhasVendas&chatID=<?= htmlspecialchars($anuncio['chatID']) ?>">
                        Ir para o Chat
                    </a>
                </p>
            <?php endif; ?>

            <!-- Excluir Produto (somente se o status for 'disponível' ou 'pausado') -->
            <?php if ($anuncio['disponibilidade'] === 'disponível' || $anuncio['disponibilidade'] === 'pausado'): ?>
                <p><a href="http://localhost/excluirAnuncio?id=<?= $anuncio['produtoID'] ?>" 
                    onclick="return confirm('Tem certeza de que deseja excluir este anúncio?')">Excluir Produto</a></p>
            <?php endif; ?>


        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>Você não possui anúncios cadastrados.</p>
<?php endif; ?>
