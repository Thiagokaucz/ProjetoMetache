<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat ID: <?= htmlspecialchars($chatId) ?></title>
    <link rel="stylesheet" href="path/to/your/style.css"> <!-- Substitua pelo caminho correto -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Incluindo jQuery -->
    <script>
        // Função para buscar as mensagens via AJAX
        function fetchMessages() {
            $.ajax({
                url: "/getMessagesAjax?id=<?= $chatId ?>", // Verifique se o caminho está correto
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var messagesHtml = '';
                    if (data.length > 0) {
                        data.forEach(function(message) {
                            messagesHtml += `
                                <li>
                                    <strong>Usuário ID ${message.userID}:</strong>
                                    ${message.conteudo} <br>
                                    <small>${message.dataHora}</small><br>
                                    ${message.linkcompra ? '<strong>Link de Compra:</strong> <a href="CompraLinkChat?id=' + message.linkcompra + '&produtoID=<?= htmlspecialchars($_SESSION['produtoID']) ?>' + '" target="_blank">' + message.linkcompra + '</a>' : ''}
                                </li>`;
                        });
                    } else {
                        messagesHtml = '<p>Nenhuma mensagem encontrada para este chat.</p>';
                    }
                    $('#messages').html(messagesHtml); // Atualiza o HTML com as mensagens
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Erro na requisição AJAX: " + textStatus + ", " + errorThrown);
                }
            });
        }

        // Chama a função de busca a cada 5 segundos
        setInterval(fetchMessages, 500);

        // Carrega as mensagens assim que a página é carregada
        $(document).ready(function() {
            fetchMessages();
        });
    </script>
</head>
<body>
    <h1>Chat do comprador</h1>
    <h1>Mensagens do Chat ID: <?= htmlspecialchars($chatId) ?></h1>

    <!-- Exibe as mensagens iniciais -->
    <ul id="messages">
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $message): ?>
                <li>
                    <strong>Usuário ID <?= htmlspecialchars($message['userID']) ?>:</strong>
                    <?= htmlspecialchars($message['conteudo']) ?><br>
                    <small><?= htmlspecialchars($message['dataHora']) ?></small><br>
                    <?php if (!empty($message['linkcompra'])): ?>
                        <strong>Link de Compra:</strong> <a href="CompraLinkChat?id=<?= htmlspecialchars($message['linkcompra']) ?>&produtoID=<?= htmlspecialchars($_SESSION['produtoID']) ?>" target="_blank"><?= htmlspecialchars($message['linkcompra']) ?></a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma mensagem encontrada para este chat.</p>
        <?php endif; ?>
    </ul>

    <!-- Formulário para enviar nova mensagem -->
    <form action="/sendMessage" method="POST">
        <input type="hidden" name="chatId" value="<?= htmlspecialchars($chatId) ?>">
        <textarea name="message" rows="3" placeholder="Digite sua mensagem..." required></textarea>
        <button type="submit">Enviar</button>
    </form>

    <a href="/chat">Voltar</a> <!-- Link de navegação de volta -->
</body>
</html>
