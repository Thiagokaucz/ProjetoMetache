<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pagamento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 2rem;
            padding: 1.5rem;
            border: 1px solid #dee2e6;
            border-radius: .5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-custom {
            background-color: #FF6B01;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #e65c00;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Detalhes do Pagamento</h2>
        <?php if ($detalhes): ?>
            <table class="table table-bordered">
                <tr><th>Pagamento ID</th><td><?php echo $detalhes['pagamento']['payment_id']; ?></td></tr>
                <tr><th>Valor da Compra</th><td><?php echo number_format($detalhes['pagamento']['valor_compra'], 2, ',', '.'); ?></td></tr>
                <tr><th>Data de Criação</th><td><?php echo date('d/m/Y H:i', strtotime($detalhes['pagamento']['created_at'])); ?></td></tr>
                <tr><th>Vendedor</th><td><?php echo $detalhes['vendedor']['nome'] . ' ' . $detalhes['vendedor']['sobrenome']; ?></td></tr>
                <tr><th>Email do Vendedor</th><td><?php echo $detalhes['vendedor']['email']; ?></td></tr>
                <tr><th>Produto</th><td><?php echo htmlspecialchars($detalhes['pagamento']['titulo_produto']); ?></td></tr>
                <tr><th>Foto do Produto</th><td><img src="<?php echo htmlspecialchars($detalhes['pagamento']['imagem_produto']); ?>" alt="Imagem do Produto" style="width: 100px; height: auto;"></td></tr>
            </table>

            <?php if (!empty($detalhes['denuncia'])): ?>
                <h4>Denúncia Associada</h4>
                <table class="table table-bordered">
                    <tr><th>Motivo</th><td><?php echo htmlspecialchars($detalhes['denuncia']['motivo']); ?></td></tr>
                    <tr><th>Status</th><td><?php echo htmlspecialchars($detalhes['denuncia']['status']); ?></td></tr>
                    <tr><th>Data de Criação</th><td><?php echo date('d/m/Y H:i', strtotime($detalhes['denuncia']['dataCriacao'])); ?></td></tr>
                </table>
                <form action="/atualizarStatusDenuncia" method="post">
                    <input type="hidden" name="aquisicaoID" value="<?php echo $detalhes['pagamento']['aquisicaoID']; ?>">
                    <input type="hidden" name="pagamentoID" value="<?php echo $detalhes['pagamento']['id']; ?>">
                    
                    <label for="novoStatus">Alterar Status da Denúncia:</label>
                    <select name="novoStatus" id="novoStatus" class="form-select">
                        <option value="nao_verificada" <?php if ($detalhes['denuncia']['status'] == 'nao_verificada') echo 'selected'; ?>>Não Verificada</option>
                        <option value="denuncia_aprovada" <?php if ($detalhes['denuncia']['status'] == 'denuncia_aprovada') echo 'selected'; ?>>Denúncia Aprovada</option>
                        <option value="denuncia_negada" <?php if ($detalhes['denuncia']['status'] == 'denuncia_negada') echo 'selected'; ?>>Denúncia Negada</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Atualizar</button>
                </form>

                <?php if ($detalhes['denuncia']['status'] == 'denuncia_aprovada'): ?>
                    <a href="/cancelarCompra?id=<?php echo $detalhes['pagamento']['aquisicaoID']; ?>" class="btn btn-danger mt-3" onclick="return confirmarCancelamento();">Cancelar compra e devolver Dinheiro</a>
                    <?php elseif ($detalhes['denuncia']['status'] == 'denuncia_negada'): ?>
                    <form action="/pagamentoVendedor?id=<?php echo $detalhes['pagamento']['id']; ?>" method="post" onsubmit="return confirmarPagamento();">
                        <button type="submit" class="btn btn-custom mt-3">Realizar pagamento</button>
                    </form>
                <?php endif; ?>

                <script>
                    function confirmarPagamento() {
                        return confirm("Tem certeza de que deseja marcar este pagamento como pago?");
                    }

                    function confirmarCancelamento() {
                        return confirm("Tem certeza de que deseja cancelar a compra e devolver o dinheiro?");
                    }
                </script>


            <?php else: ?>
                <p class="text-warning mt-3">Não houve denúncia associada a esta compra.</p>
                <form action="/pagamentoVendedor?id=<?php echo $detalhes['pagamento']['id']; ?>" method="post" onsubmit="return confirmarPagamento();">
                    <button type="submit" class="btn btn-custom mt-3">Realizar pagamento</button>
                </form>
            <?php endif; ?>


        <?php else: ?>
            <p>Nenhum pagamento encontrado.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
        function confirmarPagamento() {
            return confirm("Tem certeza de que deseja marcar este pagamento como pago?");
        }
    </script>
</body>
</html>