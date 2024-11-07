<?php

require_once 'app/models/DocumentoModel.php';

class DocumentoController {
    private $model;

    public function __construct() {
        $this->model = new DocumentoModel();
    }

    // Função para exibir o formulário de upload
    public function mostrarFormularioUpload() {
        // Obtém o compraspagamento da URL
        $compraspagamento = $_GET['compraspagamento'] ?? null;

        if ($compraspagamento) {
            // Inclui o formulário de upload e passa o compraspagamento
            include 'app/views/uploadDocumentos.php';
        } else {
            echo "ID de compra não fornecido.";
        }
    }

    // Função para processar o upload dos documentos
    public function anexarDocumentos() {
        // Obtém o compraspagamentoID enviado pelo formulário
        $compraspagamento = $_POST['compraspagamento'] ?? null;

        if ($compraspagamento && isset($_FILES['notaFiscal']) && isset($_FILES['compPagamento'])) {
            // Define os caminhos para salvar os arquivos
            $caminhoNotaFiscal = 'uploads/NotaFiscal/' . $compraspagamento . '_notaFiscal.pdf';
            $caminhoCompPagamento = 'uploads/compPagamento/' . $compraspagamento . '_compPagamento.pdf';

            // Cria as pastas caso não existam
            if (!is_dir('uploads/NotaFiscal')) {
                mkdir('uploads/NotaFiscal', 0777, true);
            }
            if (!is_dir('uploads/compPagamento')) {
                mkdir('uploads/compPagamento', 0777, true);
            }

            // Move os arquivos para os diretórios designados
            $notaFiscalSalva = move_uploaded_file($_FILES['notaFiscal']['tmp_name'], $caminhoNotaFiscal);
            $compPagamentoSalva = move_uploaded_file($_FILES['compPagamento']['tmp_name'], $caminhoCompPagamento);

            if ($notaFiscalSalva && $compPagamentoSalva) {
                // Salva os caminhos no banco de dados
                $this->model->salvarDocumentos($compraspagamento, $caminhoNotaFiscal, $caminhoCompPagamento);
                
                // Exibe a mensagem de sucesso e redireciona após 5 segundos
                echo "Documentos anexados com sucesso!";
                echo "<script>
                        setTimeout(function() {
                            window.location.href = '/homeadm';
                        }, 5000);
                      </script>";
            } else {
                echo "Erro ao salvar os arquivos. Tente novamente.";
            }
        } else {
            echo "ID de compra ou arquivos não fornecidos.";
        }
    }
}
