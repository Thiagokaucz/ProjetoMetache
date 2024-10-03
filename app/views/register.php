<?php require_once('header.php'); ?>
<h1>Registrar</h1>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<form method="POST" action="/register">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>
    <br>
    <button type="submit">Registrar</button>
</form>
<?php require_once('footer.php'); ?>
