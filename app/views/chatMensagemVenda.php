<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    
    <style>
        .chat-bubble {
            background-color: #fbe7dc;
            padding: 10px;
            border-radius: 15px;
            margin: 5px 0;
            width: fit-content;
        }
        .chat-bubble.sender {
            background-color: #f1f1f1;
            align-self: flex-end;
        }
        .chat-container {
            height: 550px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        .input-section {
            display: flex;
            align-items: center;
            padding-top: 10px;
        }
        .input-section input[type="text"] {
            flex-grow: 1;
            margin-right: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    let initialLoad = true;

    function fetchMessages() {
        const chatBox = document.getElementById('chat-box');
        const isScrolledToBottom = chatBox.scrollTop + chatBox.clientHeight >= chatBox.scrollHeight - 10;

        $.ajax({
            url: "/getMessagesAjax?id=<?= $chatId ?>", 
            type: "GET",
            dataType: "json",
            success: function(data) {
                let messagesHtml = '';
                if (data.length > 0) {
                    data.forEach(function(message) {
                        messagesHtml += `
                            <div class="chat-bubble${(message.userID === <?= json_encode($_SESSION['user_id']) ?>) ? ' sender' : ''}">
                                <p>${message.conteudo}</p>
<small class="text-muted">${
     
    new Date(message.dataHora).toLocaleDateString('pt-BR', { day: 'numeric' }) +
    ' de ' +
    new Date(message.dataHora).toLocaleDateString('pt-BR', { month: 'long' }) +
    ' às ' +
    new Date(message.dataHora).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' }) +
    'h'
}</small>

                            </div>`;
                    });
                } else {
                    messagesHtml = '<p>Nenhuma mensagem encontrada para este chat.</p>';
                }
                $('#chat-box').html(messagesHtml);

                if (initialLoad || isScrolledToBottom) {
                    scrollToBottom();
                    initialLoad = false;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Erro na requisição AJAX: " + textStatus + ", " + errorThrown);
            }
        });
    }

    function scrollToBottom() {
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    setInterval(fetchMessages, 1000);

    $(document).ready(function() {
        fetchMessages();

        function formatCurrency(input) {
            $(input).on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                let formattedValue = (value / 100).toFixed(2).replace('.', ',');
                formattedValue = formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(formattedValue);
            });
        }

        formatCurrency('#valorBrutoCompra');
        formatCurrency('#valorFrete');
    });
    </script>
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row">
        
        <div class="col-md-7 mb-3">
            <div class="card">
                <div class="card-header">
                    <strong><?= htmlspecialchars($compradorNome)?></strong> <span class="text-success">&#9679;</span>
                </div>
                <div class="card-body chat-container" id="chat-box">
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="chat-bubble<?= ($message['userID'] === $_SESSION['user_id']) ? ' sender' : '' ?>">
                                <p><?= htmlspecialchars($message['conteudo']) ?></p>
                                <small class="text-muted"><?= htmlspecialchars($message['dataHora']) ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhuma mensagem encontrada para este chat.</p>
                    <?php endif; ?>
                </div>
                <div class="card-footer input-section">
                    <form action="/sendMessage" method="POST" class="d-flex w-100">
                        <input type="hidden" name="chatId" value="<?= htmlspecialchars($chatId) ?>">
                        <input type="text" name="message" class="form-control me-2" placeholder="Digite sua mensagem..." required aria-label="Digite sua mensagem">
                        <button type="submit" class="btn" style="background-color: #FF6B01; color: white; border: none;">Enviar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Negociando produto</h5>
                    <a href="/detalheProduto?id=<?= htmlspecialchars($produtoDetalhes['produtoID']) ?>&noChat" class="d-flex align-items-center text-decoration-none text-dark">
                        <img src="<?= $produtoDetalhes['locImagem'] ?>" alt="Imagem do produto" class="produto-img" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                        <div class="ms-3">
                            <h6 class="mb-0"><?= htmlspecialchars($produtoDetalhes['titulo']) ?></h6>
                            <span class="text-muted"><?= htmlspecialchars($produtoDetalhes['valor']) ?></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Enviar link de compra:</h6>
                    <form id="linkCompraForm" action="/enviarLinkCompra" method="POST">
                        <input type="hidden" name="chatId" value="<?= htmlspecialchars($chatId) ?>">
                        <div class="mb-3">
                            <label for="valorBrutoCompra" class="form-label">Coloque o valor do produto:</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control" id="valorBrutoCompra" name="valorBrutoCompra" placeholder="0,00" required>
                            </div>
                            <div class="alert alert-warning mt-2 p-1">
                                <small>⚠️ Atenção: Lembre de combinar o frete com o comprador antes de continuar.</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="valorFrete" class="form-label">Coloque o valor do frete:</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control" id="valorFrete" name="valorFrete" placeholder="0,00">
                            </div>
                            <p>Precisa de ajuda para precificar?<a href="/sobre?section=precificar" class="text-dark fw-bold">Precificar produto</a>.</p>
                            <div class="alert alert-warning mt-2 p-1">
                                <small>⚠️ Após gerar o link de compra, ele será válido por 2 horas.</small>
                            </div>
                        </div>
                        <div class="alert alert-info p-2">
                            <small>💳 A plataforma utiliza integração com Mercado Pago.</small>
                        </div>       
                        <button type="button" class="btn w-100" style="background-color: #FF6B01; color: white; border: none;" onclick="mostrarModalConfirmacao()">
                            Enviar link de venda
                        </button>
                        <p class="mb-0">Caso houver dúvida, acesse <a href="/sobre?section=venda" class="text-dark fw-bold">Como vender com Metache</a>.</p>
                    </form>
                </div>
            </div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmação de Taxa e Valor Recebido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>A plataforma Metache cobrará 5% do valor total.</p>
                <p><strong>Valor Total:</strong> R$ <span id="valorTotalModal">0,00</span></p>
                <p><strong>Taxa da Plataforma (5%):</strong> R$ <span id="taxaPlataforma">0,00</span></p>
                <p><strong>Valor que o Vendedor Receberá:</strong> R$ <span id="valorVendedorRecebera">0,00</span></p>
                <hr>
                <div class="alert alert-warning p-2">
                    <small>⚠️ O pagamento ao vendedor só será realizado após a entrega do produto e a verificação do processo pela nossa equipe.</small><br>
                    <small>⚠️ Caso não haja reclamações por parte do cliente em até 2 meses, o valor será liberado automaticamente ao vendedor.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="confirmarEnvio()">Estou ciente, quero continuar</button>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarModalConfirmacao() {

    const valorProdutoInput = document.getElementById('valorBrutoCompra').value;
    const valorFreteInput = document.getElementById('valorFrete').value;

    const valorProduto = parseFloat(valorProdutoInput.replace(/\./g, '').replace(',', '.')) || 0;
    const valorFrete = parseFloat(valorFreteInput.replace(/\./g, '').replace(',', '.')) || 0;

    if (valorProduto <= 0 || valorFrete < 0) {
        alert("Por favor, insira valores válidos para o produto e o frete.");
        return;
    }

    const valorTotal = valorProduto + valorFrete;
    const taxa = valorTotal * 0.05;
    const valorRecebidoVendedor = valorTotal - taxa;

    document.getElementById('valorTotalModal').textContent = valorTotal.toFixed(2).replace('.', ',');
    document.getElementById('taxaPlataforma').textContent = taxa.toFixed(2).replace('.', ',');
    document.getElementById('valorVendedorRecebera').textContent = valorRecebidoVendedor.toFixed(2).replace('.', ',');

    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    confirmModal.show();
}

function confirmarEnvio() {
    document.getElementById('linkCompraForm').submit();
}
</script>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
