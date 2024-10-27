<h1>Enviar Produto</h1>

<form action="/enviarProdutoForm?aquisicaoID=<?= htmlspecialchars($aquisicaoID) ?>" method="POST">
    <label for="transportadora">Transportadora:</label>
    <input type="text" name="transportadora" required>

    <label for="codigoRastreio">Código de Rastreio:</label>
    <input type="text" name="codigoRastreio" required>

    <label for="comentario">Comentário:</label>
    <textarea name="comentario"></textarea>

    <label for="dataHora">Data e Hora do Envio:</label>
    <input type="datetime-local" name="dataHora" required>

    <button type="submit">Enviar Produto</button>
</form>
