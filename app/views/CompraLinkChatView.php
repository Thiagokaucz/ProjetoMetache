<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Compra</title>

<style>
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
        .card-header-custom {
            background-color: #FF6B01;
            color: white;
        }
        .bg-light-custom {
            background-color: #FFF3E0;
        }
        .titulo-principal {
            font-family: 'SuaFontePersonalizada', sans-serif;
            font-size: 2.5rem;
            color: #FF6B01;
        }

        @media (max-width: 768px) {
            .titulo-principal {
                font-size: 1.8rem;
            }
            .btn-custom-buy, .btn-custom-cancel {
                font-size: 0.9rem;
                padding: 10px;
            }
            .card {
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body class="bg-light-custom">
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1 class="titulo-principal">Confirmação de Compra</h1>
            <p class="text-muted">Confira os detalhes do produto e finalize sua aquisição com segurança</p>
        </div>

        <?php if ($dados): ?>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header card-header-custom">
                            <h5 class="mb-0">Informações da Compra</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><strong>Valor do Anúncio:</strong></td>
                                        <td>R$ <?= htmlspecialchars($dados['valor']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Valor negociado do Frete:</strong></td>
                                        <td>R$ <?= htmlspecialchars($dados['valorFrete']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Valor negociado do Produto:</strong></td>
                                        <td>R$ <?= htmlspecialchars($dados['valorBrutoCompra']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Valor Total da Compra:</strong></td>
                                        <td>R$ <?= htmlspecialchars($dados['valorCompra']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header card-header-custom">
                            <h5 class="mb-0">Dados do Produto</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Produto ID:</strong> <?= htmlspecialchars($dados['produtoID']) ?></p>
                            <p><strong>Nome do Produto:</strong> <?= htmlspecialchars($dados['titulo']) ?></p>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-around">
                        <form method="POST" action="/tratarCompra" class="mb-2 mb-md-0 me-md-2 w-100">
                            <input type="hidden" name="linkCompraID" value="<?= htmlspecialchars($dados['linkCompraID']) ?>">
                            <input type="hidden" name="produtoID" value="<?= htmlspecialchars($dados['produtoID']) ?>">
                            <input type="hidden" name="userID" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
                            <input type="hidden" name="chatID" value="<?= htmlspecialchars($dados['chatID']) ?>">
                            <input type="hidden" name="vendedorID" value="<?= htmlspecialchars($dados['vendedorID']) ?>">
                            <input type="hidden" name="valorBrutoCompra" value="<?= htmlspecialchars($dados['valorBrutoCompra']) ?>">
                            <input type="hidden" name="valorCompra" value="<?= htmlspecialchars($dados['valorCompra']) ?>">
                            <input type="hidden" name="valorFrete" value="<?= htmlspecialchars($dados['valorFrete']) ?>">
                            <button type="submit" name="acao" value="comprar" class="btn btn-custom-buy w-100">Confirmar Compra</button>
                        </form>

                        <form method="POST" action="/chatLista" class="ms-md-2 w-100">
                            <button type="submit" name="acao" value="naocomprar" class="btn btn-custom-cancel w-100">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                Nenhum dado encontrado para este link de compra.
            </div>
        <?php endif; ?>
    </div>


</body>
</html>
