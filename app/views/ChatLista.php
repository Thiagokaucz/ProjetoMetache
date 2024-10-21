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
    
    <!-- Botões para selecionar o tipo de chat -->
    <div class="btn-group" role="group" aria-label="Chat Type Selection">
        <button type="button" class="btn btn-primary" onclick="showChats('vendedores')">Minhas compras</button>
        <button type="button" class="btn btn-secondary" onclick="showChats('compradores')">Minhas vendas</button>
    </div>

    <div class="tab-content">
        <!-- Seção de chats de vendedores -->
        <div id="vendedores" class="chat-list" style="display: none;">
            <h2>Compras</h2>
            <?php if (!empty($ChatsCompras)): ?>
                <?php foreach ($ChatsCompras as $chat): ?>
                    <div class="chat-item" onclick="window.location.href='chat?Produto=<?= $chat['produtoID'] ?>&Origem=ListaChat&Tipo=MinhasCompras'">
                        <strong>Produto ID: <?= htmlspecialchars($chat['produtoID']) ?></strong> <!-- Exibindo o ID do vendedor -->
                        <!--<span class="text-muted"> - Última mensagem: <?= htmlspecialchars($chat['ultimamendagem']) ?></span>-->
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Não há chats disponíveis.</p>
            <?php endif; ?>
        </div>

        <!-- Seção de chats de compradores -->
        <div id="compradores" class="chat-list" style="display: none;">
            <h2>Vendas</h2>
            <?php if (!empty($ChatsVendas)): ?>
                <?php foreach ($ChatsVendas as $chat): ?>
                    <div class="chat-item" onclick="window.location.href='chat?Produto=<?= $chat['produtoID'] ?>&Origem=ListaChat&Tipo=MinhasVendas'">
                        <strong>Produto ID: <?= htmlspecialchars($chat['produtoID']) ?></strong> <!-- Exibindo o ID do comprador -->
                        <!--<span class="text-muted"> - Última mensagem: <?= htmlspecialchars($chat['ultimamendagem']) ?></span>-->
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Não há chats disponíveis.</p>
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
