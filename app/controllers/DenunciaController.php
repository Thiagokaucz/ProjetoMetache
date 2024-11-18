<?php
require_once 'app/models/DenunciaModel.php';

class DenunciaController {
    private $denunciaModel;

    public function __construct() {
        $this->denunciaModel = new DenunciaModel();
    }

    public function mostrarFormulario() {
        $aquisicaoID = $_GET['aquisicaoID'] ?? null;
        require_once 'app/views/header.php';
        require 'app/views/formDenuncia.php';
        require_once 'app/views/footerConfig.php';
    }

    public function criarDenuncia() {
        $aquisicaoID = $_POST['aquisicaoID'] ?? null;
        $motivo = $_POST['motivo'] ?? '';

        if ($aquisicaoID && !empty($motivo)) {
            $sucesso = $this->denunciaModel->criarDenuncia($aquisicaoID, $motivo);
            $mensagem = $sucesso ? "Denúncia criada com sucesso." : "Erro ao criar denúncia.";
        } else {
            $mensagem = "Parâmetros inválidos. Verifique o ID da aquisição e o motivo.";
        }

        require_once 'app/views/header.php';
        require 'app/views/feedbackDenuncia.php';
        require_once 'app/views/footerConfig.php';
    }
}
