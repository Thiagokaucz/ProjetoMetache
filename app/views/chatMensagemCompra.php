<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat e Link de Compra</title>
    
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
    let initialLoad = true; // Variável para controlar se é o carregamento inicial

    // Função para buscar as mensagens via AJAX
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
                                <small class="text-muted">${message.dataHora}</small>
                                ${message.linkcompra ? 
                                    (message.visualizacao === 'nao_vizualizado' ? 
                                        `<br><strong>Para aceitar, aperte no</strong> 
                                         <a href="CompraLinkChat?id=${message.linkcompra}&produtoID=<?= htmlspecialchars($_SESSION['produtoID']) ?>" target="_blank">
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

                // Rola para o fundo do chat apenas no carregamento inicial
                if (initialLoad) {
                    scrollToBottom();
                    initialLoad = false; // Após o primeiro carregamento, desativa o rolamento automático
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Erro na requisição AJAX: " + textStatus + ", " + errorThrown);
            }
        });
    }

    // Função para rolar até o final do chat
    function scrollToBottom() {
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Chama a função de busca a cada 5 segundos
    setInterval(fetchMessages, 500);

    // Carrega as mensagens assim que a página é carregada
    $(document).ready(function() {
        fetchMessages(); // Carrega as mensagens inicialmente
    });
</script>

</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row">
        
        <!-- Chat Column -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <strong><?= htmlspecialchars($compradorNome) ?></strong> <span class="text-success">&#9679;</span>
                </div>
                <div class="card-body chat-container" id="chat-box">
                    <!-- Exibe as mensagens iniciais -->
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

        <!-- Product and Purchase Link Column -->
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

            <!-- Formulário de Link de Compra -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Para realizar a compra, basta entrar no link de compra com o valor anunciado.</h6>
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
                        <div class="alert alert-info p-2">
                            <small>💳 A plataforma utiliza integração com Mercado Pago.</small>
                        </div>
                        Caso ouver duvida, acesse <a href="/sobre?section=compra">Como comprar com Metache</a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
