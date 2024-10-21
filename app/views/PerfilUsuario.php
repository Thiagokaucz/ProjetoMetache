<?php if (isset($usuario)): ?>
    <h1>Dados do Usuário</h1>
    <form action="/perfilUsuario/atualizar" method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

        <label>Sobrenome:</label>
        <input type="text" name="sobrenome" value="<?= htmlspecialchars($usuario['sobrenome']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <label>CEP:</label>
        <input type="text" name="cep" value="<?= htmlspecialchars($usuario['cep']) ?>" required>

        <label>Status da Conta:</label>
        <input type="text" name="statusConta" value="<?= htmlspecialchars($usuario['statusConta']) ?>" disabled>

        <input type="submit" value="Atualizar Dados">
    </form>

    <form action="/perfilUsuario/desativar" method="POST">
        <input type="submit" value="Desativar Conta">
    </form>
<?php else: ?>
    <p>Usuário não encontrado.</p>
<?php endif; ?>
