<h1>Login</h1>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<form method="POST" action="/login">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>
    <br>
    <button type="submit">Login</button>
</form>
<p>
    <a href="/register">Não tem uma conta? Cadastre-se aqui</a>
</p>
<p>
    <a href="/forgot-password">Esqueceu sua senha?</a>
</p>
