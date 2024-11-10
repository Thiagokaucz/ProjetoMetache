<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Compra</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        .btn-custom-buy {
            background-color: #28a745;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-custom-buy:hover {
            background-color: #218838;
        }
        .btn-custom-cancel {
            background-color: #dc3545;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-custom-cancel:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1 class="display-6">Detalhes da Compra</h1>
            <p class="text-muted">Verifique as informações do produto e finalize sua compra</p>
        </div>

        <?php if ($dados): ?>
            <div class="row justify-content-center">
                <!-- Card com os detalhes da compra -->
                <div class="col-md-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Informações da Compra</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Link de Compra ID:</strong> <?= htmlspecialchars($dados['linkCompraID']) ?></p>

                            <!-- Tabela para exibir os valores -->
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><strong>Valor do Anuncio:</strong></td>
                                        <td>R$ <?= htmlspecialchars($dados['valor']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Valor negociado do Frete:</strong></td>
                                        <td>R$ <?= htmlspecialchars($dados['valorFrete']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Valor negociado do produto:</strong></td>
                                        <td>R$ <?= htmlspecialchars($dados['valorBrutoCompra']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Valor Total da Compra:</strong></td>
                                        <td>R$ <?= htmlspecialchars($dados['valorCompra']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status do Link:</strong></td>
                                        <td><?= htmlspecialchars($dados['statusLinkCompra']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Card com os detalhes do produto -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Dados do Produto</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Produto ID:</strong> <?= htmlspecialchars($dados['produtoID']) ?></p>
                            <p><strong>Nome do Produto:</strong> <?= htmlspecialchars($dados['titulo']) ?></p>
                            <p><strong>Descrição:</strong> <?= htmlspecialchars($dados['descricao']) ?></p>
                        </div>
                    </div>

                    <!-- Formulários de ação -->
                    <div class="d-flex justify-content-around">
                        <!-- Formulário para confirmar a compra -->
                        <form method="POST" action="/tratarCompra" class="me-2">
                            <input type="hidden" name="linkCompraID" value="<?= htmlspecialchars($dados['linkCompraID']) ?>">
                            <input type="hidden" name="produtoID" value="<?= htmlspecialchars($dados['produtoID']) ?>">
                            <input type="hidden" name="userID" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
                            <input type="hidden" name="chatID" value="<?= htmlspecialchars($dados['chatID']) ?>">
                            <input type="hidden" name="vendedorID" value="<?= htmlspecialchars($dados['vendedorID']) ?>">
                            <input type="hidden" name="valorBrutoCompra" value="<?= htmlspecialchars($dados['valorBrutoCompra']) ?>">
                            <input type="hidden" name="valorCompra" value="<?= htmlspecialchars($dados['valorCompra']) ?>">
                            <input type="hidden" name="valorFrete" value="<?= htmlspecialchars($dados['valorFrete']) ?>">
                            <button type="submit" name="acao" value="comprar" class="btn btn-custom-buy w-100">Comprar</button>
                        </form>

                        <!-- Formulário para cancelar a compra -->
                        <form method="POST" action="/chatLista" class="ms-2">
                            <button type="submit" name="acao" value="naocomprar" class="btn btn-custom-cancel w-100">Não Comprar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Alerta caso os dados não sejam encontrados -->
            <div class="alert alert-warning text-center" role="alert">
                Nenhum dado encontrado para este link de compra.
            </div>
        <?php endif; ?>

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
