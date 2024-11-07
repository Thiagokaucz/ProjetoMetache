<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Documentos</title>
</head>
<body>
    <h2>Anexar Documentos de Pagamento</h2>
    
    <!-- Formulário de upload -->
    <form action="/anexarDocumentos" method="post" enctype="multipart/form-data">
        <input type="hidden" name="compraspagamento" value="<?php echo htmlspecialchars($_GET['compraspagamento']); ?>">
        
        <label for="notaFiscal">Nota Fiscal (PDF):</label>
        <input type="file" name="notaFiscal" id="notaFiscal" accept="application/pdf" required>
        
        <label for="compPagamento">Comprovante de Pagamento (PDF):</label>
        <input type="file" name="compPagamento" id="compPagamento" accept="application/pdf" required>
        
        <button type="submit">Anexar e Finalizar Compra</button>
    </form>
</body>
</html>
