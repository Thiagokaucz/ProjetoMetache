<?php if (isset($usuario)): ?>
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
                <form action="/perfilUsuario/desativar" method="POST">
                    <button type="submit" class="btn btn-danger">Desativar Conta</button>
                </form>
            </div>
        </form>
    </div>
<?php else: ?>
    <div class="container my-4">
        <p>Usuário não encontrado.</p>
    </div>
<?php endif; ?>
