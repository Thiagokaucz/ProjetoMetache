<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Chats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        .container-box {
            background-color: #FFFFFF;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
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
        .btn-group button {
            min-width: 150px;
        }
        .btn-laranja {
            background-color: #FF6B01;
            border: none;
            color: white;
        }
        .btn-laranja:hover {
            background-color: #e65b01;
            color: white;
        }
    </style>
</head>
<body style="background-color: #F8F9FA;">

<div class="container mt-5">
    <div class="container-box mb-4">
    <h4 class="mt-2 mb-4">Meus chats</h4>

    <div class="btn-group w-100 mb-3" role="group" aria-label="Seleção de Tipo de Chat">
            <button id="btnVendedores" type="button" class="btn btn-laranja" onclick="showChats('vendedores')">
                Minhas Compras (<?= count($ChatsCompras) ?>)
            </button>
            <button id="btnCompradores" type="button" class="btn btn-secondary" onclick="showChats('compradores')">
                Minhas Vendas (<?= count($ChatsVendas) ?>)
            </button>
        </div>

        <div class="row mb-4">
    <div class="col-12">
        <input type="text" id="pesquisaProduto" class="form-control" placeholder="Pesquisar pelo nome do produto" onkeyup="filtrarChats()">
    </div>
</div>

    </div>

    <div class="container-box">
        <div class="tab-content">

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
                            <!-- Botão de excluir (comentado) -->
                            <!--
                            <button class="btn btn-danger btn-sm ms-auto" onclick="excluirChat(<?= $chat['chatID'] ?>, event)">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                            -->
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Não há chats disponíveis.</p>
                <?php endif; ?>
            </div>

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
                            <!-- Botão de excluir (comentado) -->
                            <!--
                            <button class="btn btn-danger btn-sm ms-auto" onclick="excluirChat(<?= $chat['chatID'] ?>, event)">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                            -->
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Não há chats disponíveis.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>

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

    showChats('vendedores');

    function excluirChat(chatID, event) {
        event.stopPropagation(); 
        if (confirm('Tem certeza que deseja excluir este chat?')) {
            window.location.href = '/ChatListaExcluir?id=' + chatID;
        }
    }

    function filtrarChats() {
        const termoPesquisa = document.getElementById('pesquisaProduto').value.toLowerCase();
        const chats = document.querySelectorAll('.chat-item');

        chats.forEach(chat => {
            const tituloProduto = chat.querySelector('strong').textContent.toLowerCase();
            chat.style.display = tituloProduto.includes(termoPesquisa) ? 'flex' : 'none';
        });
    }
</script>

</body>
</html>
