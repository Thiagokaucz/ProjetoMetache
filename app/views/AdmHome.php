<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tela Home do Administrador">
    <title>Home do Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .card {
            border: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="header">
            <h1>Bem-vindo, <?php echo $_SESSION['admin_name']; ?>!</h1>
        </div>

        <h2>Avisos</h2>
        <div class="card mb-4">
            <div class="card-body">
                    <div class="list-group">
            <?php foreach ($avisos as $aviso): ?>
                <div class="list-group-item">
                    <h5 class="mb-1">
                        <i class="bi bi-person-circle"></i> Aviso de: <?php echo $aviso['nome_criador']; ?>
                    </h5>
                    <p class="mb-1"><?php echo $aviso['mensagem']; ?></p>
                    <small><?php echo date('d/m/Y H:i', strtotime($aviso['data_criacao'])); ?></small>
                    <form method="POST" action="/deleteAviso?id=<?php echo $aviso['avisoID']; ?>" style="display:inline;">
                        <button type="submit" class="btn btn-danger btn-sm float-end">Excluir</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <?php if (empty($avisos)): ?>
                <div class="alert alert-info" role="alert">
                    Nenhum aviso encontrado.
                </div>
            <?php endif; ?>
        </div>

            </div>
        </div>

        <h2>Resumo das Vendas</h2>
        <div class="card mb-4">
            <div class="card-body">
                <p>
                    <strong>Total de Vendas:</strong> <?php echo $resumo['totalVendas']; ?>
                </p>
                <p>
                    <strong>Valor Movimentado:</strong> R$ <?php echo number_format($resumo['valorMovimentado'], 2, ',', '.'); ?>
                </p>
                <p class="text-muted">
                    <small>Valores atualizados automaticamente.</small>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
