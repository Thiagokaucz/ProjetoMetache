<?php

require_once 'app/models/DocumentoModel.php';

class DocumentoController {
    private $model;

    public function __construct() {
        $this->model = new DocumentoModel();
    }

    public function mostrarFormularioUpload() {
        $compraspagamento = $_GET['compraspagamento'] ?? null;

        if ($compraspagamento) {
            include 'app/views/AdmHeader.php';
            include 'app/views/uploadDocumentos.php';
        } else {
            echo "ID de compra não fornecido.";
        }
    }

    public function anexarDocumentos() {
        $compraspagamento = $_POST['compraspagamento'] ?? null;

        if ($compraspagamento && isset($_FILES['notaFiscal']) && isset($_FILES['compPagamento'])) {
            $caminhoNotaFiscal = 'uploads/NotaFiscal/' . $compraspagamento . '_notaFiscal.pdf';
            $caminhoCompPagamento = 'uploads/compPagamento/' . $compraspagamento . '_compPagamento.pdf';

            if (!is_dir('uploads/NotaFiscal')) {
                mkdir('uploads/NotaFiscal', 0777, true);
            }
            if (!is_dir('uploads/compPagamento')) {
                mkdir('uploads/compPagamento', 0777, true);
            }

            $notaFiscalSalva = move_uploaded_file($_FILES['notaFiscal']['tmp_name'], $caminhoNotaFiscal);
            $compPagamentoSalva = move_uploaded_file($_FILES['compPagamento']['tmp_name'], $caminhoCompPagamento);

            if ($notaFiscalSalva && $compPagamentoSalva) {
                $this->model->salvarDocumentos($compraspagamento, $caminhoNotaFiscal, $caminhoCompPagamento);
                
                echo '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Sucesso</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                </head>
                <body class="d-flex justify-content-center align-items-center bg-light" style="height: 100vh;">
                    <div class="container text-center">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">✅ Documentos anexados com sucesso!</h4>
                            <p class="mb-0">Você será redirecionado em breve.</p>
                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    <script>
                        setTimeout(function() {
                            window.location.href = "/homeadm";
                        }, 5000);
                    </script>
                </body>
                </html>';
            } else {
                echo "Erro ao salvar os arquivos. Tente novamente.";
            }
        } else {
            echo "ID de compra ou arquivos não fornecidos.";
        }
    }
}
