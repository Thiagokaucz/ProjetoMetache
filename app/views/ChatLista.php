<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Chats</title>
    <style>
        .chat-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
            cursor: pointer;
        }
        .chat-item img {
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }
        .chat-item:hover {
            background-color: #f8f9fa;
        }
        .chat-item-info {
            display: flex;
            flex-direction: column;
        }
        .chat-item strong {
            font-size: 16px;
        }
        .chat-item span {
            color: #888;
            font-size: 14px;
        }
        .tab-content {
            margin-top: 20px;
        }
        .btn-danger {
            background-color: red;
            border: none;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    
    <!-- Botões para selecionar o tipo de chat -->
    <div class="btn-group" role="group" aria-label="Chat Type Selection">
        <button type="button" class="btn btn-primary" onclick="showChats('vendedores')">
            Minhas compras (<?= count($ChatsCompras) ?>)
        </button>
        <button type="button" class="btn btn-secondary" onclick="showChats('compradores')">
            Minhas vendas (<?= count($ChatsVendas) ?>)
        </button>
    </div>

    <!-- Campo de pesquisa -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="pesquisaProduto" class="form-control" placeholder="Pesquisar pelo nome do produto" onkeyup="filtrarChats()">
        </div>
    </div>

    <div class="tab-content">
        <!-- Seção de chats de compras -->
        <div id="vendedores" class="chat-list" style="display: none;">
            <h2>Compras</h2>
            <?php if (!empty($ChatsCompras)): ?>
                <?php foreach ($ChatsCompras as $chat): ?>
                    <div class="chat-item" onclick="window.location.href='chat?Produto=<?= $chat['produtoID'] ?>&Origem=ListaChat&Tipo=MinhasCompras&chatID=<?= $chat['chatID'] ?>'">
                        <img src="<?= htmlspecialchars($chat['locImagem']) ?>" alt="Imagem do Produto">
                        <div class="chat-item-info">
                            <strong><?= htmlspecialchars($chat['produtoTitulo']) ?></strong>
                            <span>Vendedor: <?= htmlspecialchars($chat['vendedorNome']) ?></span>
                        </div>
                        <!-- Botão de excluir -->
                        <button class="btn btn-danger btn-sm ml-auto" onclick="excluirChat(<?= $chat['chatID'] ?>, event)">
                            <i class="fas fa-trash-alt"></i> Excluir
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Não há chats disponíveis.</p>
            <?php endif; ?>
        </div>

        <!-- Seção de chats de vendas -->
        <div id="compradores" class="chat-list" style="display: none;">
            <h2>Vendas</h2>
            <?php if (!empty($ChatsVendas)): ?>
                <?php foreach ($ChatsVendas as $chat): ?>
                    <div class="chat-item" onclick="window.location.href='chat?Produto=<?= $chat['produtoID'] ?>&Origem=ListaChat&Tipo=MinhasVendas&chatID=<?= $chat['chatID'] ?>'">
                        <img src="<?= htmlspecialchars($chat['locImagem']) ?>" alt="Imagem do Produto">
                        <div class="chat-item-info">
                            <strong><?= htmlspecialchars($chat['produtoTitulo']) ?></strong>
                            <span>Comprador: <?= htmlspecialchars($chat['compradorNome']) ?></span>
                        </div>
                        <!-- Botão de excluir -->
                        <button class="btn btn-danger btn-sm ml-auto" onclick="excluirChat(<?= $chat['chatID'] ?>, event)">
                            <i class="fas fa-trash-alt"></i> Excluir
                        </button>
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

    // Função para excluir o chat
    function excluirChat(chatID, event) {
        event.stopPropagation(); // Evita que o clique no botão de excluir redirecione para o chat
        if (confirm('Tem certeza que deseja excluir este chat?')) {
            window.location.href = '/ChatListaExcluir?id=' + chatID;
        }
    }

    // Função para filtrar chats
    function filtrarChats() {
        const termoPesquisa = document.getElementById('pesquisaProduto').value.toLowerCase();
        const chats = document.querySelectorAll('.chat-item');

        chats.forEach(chat => {
            const tituloProduto = chat.querySelector('strong').textContent.toLowerCase();
            
            // Filtrar por termo de pesquisa
            if (tituloProduto.includes(termoPesquisa)) {
                chat.style.display = 'flex';
            } else {
                chat.style.display = 'none';
            }
        });
    }
</script>

</body>
</html>
