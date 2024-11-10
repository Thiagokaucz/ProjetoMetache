<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Chats</title>
    <!-- Bootstrap CSS versão 5.3 -->
    <style>
        /* CSS personalizado */
        .chat-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .chat-item:hover {
            background-color: #f1f3f5;
        }
        .chat-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }
        .chat-item-info strong {
            font-size: 1rem;
            color: #495057;
        }
        .chat-item-info span {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .tab-content {
            margin-top: 20px;
        }
        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .btn-group button {
            min-width: 150px;
        }
        .btn-laranja {
            background-color: #FF6B01;
            border: none;
            color: white; /* Cor do texto para o botão laranja */
        }
        .btn-laranja:hover {
            background-color: #e65b01;
            color: white; /* Cor do texto para o botão laranja */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    
    <!-- Botões para selecionar o tipo de chat -->
    <div class="btn-group mb-3" role="group" aria-label="Chat Type Selection">
        <button id="btnVendedores" type="button" class="btn btn-laranja" onclick="showChats('vendedores')">
            Minhas compras (<?= count($ChatsCompras) ?>)
        </button>
        <button id="btnCompradores" type="button" class="btn btn-secondary" onclick="showChats('compradores')">
            Minhas vendas (<?= count($ChatsVendas) ?>)
        </button>
    </div>

    <!-- Campo de pesquisa -->
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" id="pesquisaProduto" class="form-control" placeholder="Pesquisar pelo nome do produto" onkeyup="filtrarChats()">
        </div>
    </div>

    <div class="tab-content">
        <!-- Seção de chats de compras -->
        <div id="vendedores" class="chat-list" style="display: none;">
            <h4>Compras</h4>
            <?php if (!empty($ChatsCompras)): ?>
                <?php foreach ($ChatsCompras as $chat): ?>
                    <div class="chat-item shadow-sm rounded" onclick="window.location.href='chat?Produto=<?= $chat['produtoID'] ?>&Origem=ListaChat&Tipo=MinhasCompras&chatID=<?= $chat['chatID'] ?>'">
                        <img src="<?= htmlspecialchars($chat['locImagem']) ?>" alt="Imagem do Produto">
                        <div class="chat-item-info">
                            <strong><?= htmlspecialchars($chat['produtoTitulo']) ?></strong>
                            <span>Vendedor: <?= htmlspecialchars($chat['vendedorNome']) ?></span>
                        </div>
                        <!-- Botão de excluir -->
                        <button class="btn btn-danger btn-sm ms-auto" onclick="excluirChat(<?= $chat['chatID'] ?>, event)">
                            <i class="fas fa-trash-alt"></i> Excluir
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Não há chats disponíveis.</p>
            <?php endif; ?>
        </div>

        <!-- Seção de chats de vendas -->
        <div id="compradores" class="chat-list" style="display: none;">
            <h4>Vendas</h4>
            <?php if (!empty($ChatsVendas)): ?>
                <?php foreach ($ChatsVendas as $chat): ?>
                    <div class="chat-item shadow-sm rounded" onclick="window.location.href='chat?Produto=<?= $chat['produtoID'] ?>&Origem=ListaChat&Tipo=MinhasVendas&chatID=<?= $chat['chatID'] ?>'">
                        <img src="<?= htmlspecialchars($chat['locImagem']) ?>" alt="Imagem do Produto">
                        <div class="chat-item-info">
                            <strong><?= htmlspecialchars($chat['produtoTitulo']) ?></strong>
                            <span>Comprador: <?= htmlspecialchars($chat['compradorNome']) ?></span>
                        </div>
                        <!-- Botão de excluir -->
                        <!--<button class="btn btn-danger btn-sm ms-auto" onclick="excluirChat(<?= $chat['chatID'] ?>, event)">
                            <i class="fas fa-trash-alt"></i> Excluir
                        </button> -->
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Não há chats disponíveis.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- JavaScript do Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Função para exibir chats e alterar o botão ativo
    function showChats(type) {
        document.getElementById('vendedores').style.display = 'none';
        document.getElementById('compradores').style.display = 'none';

        document.getElementById('btnVendedores').classList.remove('btn-laranja');
        document.getElementById('btnCompradores').classList.remove('btn-laranja');

        document.getElementById('btnVendedores').classList.add('btn-secondary');
        document.getElementById('btnCompradores').classList.add('btn-secondary');

        if (type === 'vendedores') {
            document.getElementById('vendedores').style.display = 'block';
            document.getElementById('btnVendedores').classList.add('btn-laranja');
            document.getElementById('btnVendedores').classList.remove('btn-secondary');
        } else if (type === 'compradores') {
            document.getElementById('compradores').style.display = 'block';
            document.getElementById('btnCompradores').classList.add('btn-laranja');
            document.getElementById('btnCompradores').classList.remove('btn-secondary');
        }
    }

    // Exibir chats de vendedores por padrão ao carregar a página
    showChats('vendedores');

    // Função para excluir o chat
    function excluirChat(chatID, event) {
        event.stopPropagation(); 
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
