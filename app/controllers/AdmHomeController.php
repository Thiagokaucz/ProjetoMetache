<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once 'app/models/AvisosAdmModel.php';

class AdmHomeController {
    public function index() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admlogin');
            exit();
        }

        $avisos = [];
        $resumo = [
            'totalVendas' => 0,
            'valorMovimentado' => 0,
        ];
    
        $admModel = new AvisosAdmModel();
        $avisos = $admModel->getAvisos($_SESSION['admin_id']);
        $resumo = $this->getResumoVendas();

        include 'app/views/AdmHeader.php';
        require 'app/views/AdmHome.php';
    }
    
    private function getResumoVendas() {
        $database = new Database();
        $conn = $database->obterConexao();
    
        $queryTotalVendas = "SELECT COUNT(*) AS total FROM compraspagamento WHERE statusAdmMetache != 'compra_cancelada'";
        $stmtTotalVendas = $conn->prepare($queryTotalVendas);
        $stmtTotalVendas->execute();
        $totalVendas = $stmtTotalVendas->fetchColumn();
    
        $queryValorMovimentado = "SELECT SUM(valor_compra) AS totalValor FROM compraspagamento WHERE statusAdmMetache != 'compra_cancelada'";
        $stmtValorMovimentado = $conn->prepare($queryValorMovimentado);
        $stmtValorMovimentado->execute();
        $valorMovimentado = $stmtValorMovimentado->fetchColumn();
    
        return [
            'totalVendas' => $totalVendas,
            'valorMovimentado' => $valorMovimentado ? $valorMovimentado : 0,
        ];
    }
    
    public function delete() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admlogin');
            exit();
        }

        if (isset($_GET['id'])) {
            $avisoID = $_GET['id'];
            $admModel = new AvisosAdmModel();
            $admModel->deleteAviso($avisoID);
        }
    
        header('Location: /homeadm');
        exit();
    }
}
?>
