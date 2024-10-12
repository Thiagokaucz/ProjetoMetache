<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Chats</title>
    <style>
        .chat-item {
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
            cursor: pointer; /* Muda o cursor para indicar que é clicável */
        }
        .chat-item:hover {
            background-color: #f8f9fa; /* Efeito hover */
        }
        .tab-content {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1>Chats</h1>
    
    <!-- Botões para selecionar o tipo de chat -->
    <div class="btn-group" role="group" aria-label="Chat Type Selection">
        <button type="button" class="btn btn-primary" onclick="showChats('vendedores')">Vendedores</button>
        <button type="button" class="btn btn-secondary" onclick="showChats('compradores')">Compradores</button>
    </div>

    <div class="tab-content">
        <!-- Seção de chats de vendedores -->
        <div id="vendedores" class="chat-list" style="display: none;">
            <h2>Chats de Vendedores</h2>
            <?php if (!empty($vendedorChats)): ?>
                <?php foreach ($vendedorChats as $chat): ?>
                    <div class="chat-item" onclick="window.location.href='chat?id=<?= $chat['chatID'] ?>'">
                        <strong>Chat ID: <?= htmlspecialchars($chat['chatID']) ?></strong> <!-- Exibindo o ID do vendedor -->
                        <span class="text-muted"> - Última mensagem: <?= htmlspecialchars($chat['ultimamendagem']) ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Não há chats de vendedores disponíveis.</p>
            <?php endif; ?>
        </div>

        <!-- Seção de chats de compradores -->
        <div id="compradores" class="chat-list" style="display: none;">
            <h2>Chats de Compradores</h2>
            <?php if (!empty($compradorChats)): ?>
                <?php foreach ($compradorChats as $chat): ?>
                    <div class="chat-item" onclick="window.location.href='chat.php?chatID=<?= $chat['chatID'] ?>'">
                        <strong>Comprador ID: <?= htmlspecialchars($chat['destinatarioID']) ?></strong> <!-- Exibindo o ID do comprador -->
                        <span class="text-muted"> - Última mensagem: <?= htmlspecialchars($chat['ultimamendagem']) ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Não há chats de compradores disponíveis.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Função para exibir chats com base na seleção do usuário
    function showChats(type) {
        // Ocultar todas as seções
        document.getElementById('vendedores').style.display = 'none';
        document.getElementById('compradores').style.display = 'none';

        // Mostrar a seção selecionada
        if (type === 'vendedores') {
            document.getElementById('vendedores').style.display = 'block';
        } else if (type === 'compradores') {
            document.getElementById('compradores').style.display = 'block';
        }
    }

    // Exibir chats de vendedores por padrão ao carregar a página
    showChats('vendedores');
</script>

</body>
</html>
