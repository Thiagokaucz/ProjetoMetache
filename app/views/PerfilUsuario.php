<head>
  <title>Perfil</title>
</head>

<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <div id="notification" class="notification-success">
        Dados atualizados com sucesso!
    </div>
<?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
    <div id="notification" class="notification-error">
        Erro ao atualizar os dados.
    </div>
<?php endif; ?>

<div class="container my-4">
    <h1 class="mb-4">Dados do Usuário</h1>

    <form action="/perfilUsuario/atualizar" method="POST" class="border p-4 rounded shadow">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="sobrenome" class="form-label">Sobrenome:</label>
            <input type="text" name="sobrenome" id="sobrenome" class="form-control" value="<?= htmlspecialchars($usuario['sobrenome']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="cep" class="form-label">CEP:</label>
            <input type="text" name="cep" id="cep" class="form-control" value="<?= htmlspecialchars($usuario['cep']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="statusConta" class="form-label">Status da Conta:</label>
            <input type="text" name="statusConta" id="statusConta" class="form-control" value="<?= htmlspecialchars($usuario['statusConta']) ?>" disabled>
        </div>

        <div class="d-flex mt-4">
            <button type="submit" class="btn btn-primary me-2">Atualizar Dados</button>
            <button type="button" class="btn btn-danger" onclick="desativarConta()">Desativar Conta</button>
        </div>
    </form>
</div>

<script>

function desativarConta() {
    document.getElementById('statusConta').value = 'Desativada'; 
    var form = document.createElement('form'); 
    form.method = 'POST';
    form.action = '/perfilUsuario/desativar';
    document.body.appendChild(form);
    form.submit(); 
}

setTimeout(function() {
    var notification = document.getElementById('notification');
    if (notification) {
        notification.style.opacity = '0';
    }
}, 3000);
</script>

<style>
#notification {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    padding: 15px;
    border-radius: 5px;
    color: white;
    z-index: 1000;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    transition: opacity 0.5s ease;
}

.notification-success {
    background-color: #4CAF50;
}

.notification-error {
    background-color: #f44336;
}
</style>
