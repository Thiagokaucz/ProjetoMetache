<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    
    <!-- Bootstrap CSS -->
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
            height: 500px;
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
                                ${message.linkcompra ? 
                                    (message.visualizacao === 'nao_vizualizado' ? 
                                        `<br><strong>Para aceitar, aperte no</strong> 
         <a href="CompraLinkChat?id=${message.linkcompra}&produtoID=<?= htmlspecialchars($_SESSION['produtoID']) ?>" target="_blank" style="color: green;">
            Link de compra
         </a>` : 
                                         `<br><strong>Link já foi aberto</strong>`
                                    ) : ''}
                            </div>`;
                    });
                } else {
                    messagesHtml = '<p>Nenhuma mensagem encontrada para este chat.</p>';
                }
                $('#chat-box').html(messagesHtml);

                if (initialLoad) {
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

    setInterval(fetchMessages, 500);

    $(document).ready(function() {
        fetchMessages(); 
    });
</script>

</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row">
        
        <div class="col-md-7 mb-3">
            <div class="card">
                <div class="card-header">
                    <strong><?= htmlspecialchars($compradorNome) ?></strong> <span class="text-success">&#9679;</span>
                </div>
                <div class="card-body chat-container" id="chat-box">

                <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="chat-bubble<?= ($message['userID'] === $_SESSION['user_id']) ? ' sender' : '' ?>">
                                <p><?= htmlspecialchars($message['conteudo']) ?></p>
                                <small class="text-muted"><?= htmlspecialchars($message['dataHora']) ?></small>
                                <?php if (!empty($message['linkcompra'])): ?>
                                    <?php if ($message['visualizacao'] === 'nao_vizualizado'): ?>
                                        <br><strong>Para aceitar, aperte no</strong> 
                                        <a href="CompraLinkChat?id=<?= htmlspecialchars($message['linkcompra']) ?>&produtoID=<?= htmlspecialchars($_SESSION['produtoID']) ?>" target="_blank">
                                            Link de compra
                                        </a>
                                    <?php else: ?>
                                        <br><strong>Link já foi aberto</strong>
                                    <?php endif; ?>
                                <?php endif; ?>
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
                    <h6 class="card-title">Para realizar a compra, basta clicar no link de compra com o valor negociado.</h6>
                    <form action="/enviarLinkCompra" method="POST">
                        <div class="mb-3">
                            <div class="alert alert-warning mt-2 p-1">
                                <small>⚠️ Atenção: Lembre de combinar o frete com o vendedor antes de continuar.</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="alert alert-warning mt-2 p-1">
                                <small>⚠️ Aviso: Caso a compra nao seja realizada dentro de 2 meses nossa equipe entrara em contato para entender o motivo.</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="alert alert-warning mt-2 p-1">
                                <small>⚠️ Após gerar o link de compra, ele será válido por 2 horas.</small>
                            </div>
                        </div>
                        <div class="alert alert-success p-2">
                            <small>✅ A plataforma utiliza integração com Mercado Pago.</small>
                        </div>
                        <p class="mb-0">Caso houver dúvida, acesse <a href="/sobre?section=compra" class="text-dark fw-bold">Como comprar com Metache</a>.</p>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
