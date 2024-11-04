<?php
session_start();

require_once 'app/models/AvisosAdmModel.php';

class AdmHomeController {
    public function index() {
        $avisos = [];
        $resumo = [
            'totalVendas' => 0,
            'valorMovimentado' => 0,
        ];
    
        if (isset($_SESSION['admin_id'])) {
            $admModel = new AvisosAdmModel();
            $avisos = $admModel->getAvisos($_SESSION['admin_id']);
    
            // Obter o total de vendas e o valor movimentado
            $resumo = $this->getResumoVendas();
        }

        include 'app/views/AdmHeader.php';
        require 'app/views/AdmHome.php'; // View para a tela home do administrador
    }
    
    private function getResumoVendas() {
        $database = new Database();
        $conn = $database->obterConexao();
    
        // Contar o total de vendas
        $queryTotalVendas = 'SELECT COUNT(*) AS total FROM comprasPagamento';
        $stmtTotalVendas = $conn->prepare($queryTotalVendas);
        $stmtTotalVendas->execute();
        $totalVendas = $stmtTotalVendas->fetchColumn();
    
        // Somar o valor movimentado
        $queryValorMovimentado = 'SELECT SUM(valor_compra) AS totalValor FROM comprasPagamento';
        $stmtValorMovimentado = $conn->prepare($queryValorMovimentado);
        $stmtValorMovimentado->execute();
        $valorMovimentado = $stmtValorMovimentado->fetchColumn();
    
        return [
            'totalVendas' => $totalVendas,
            'valorMovimentado' => $valorMovimentado ? $valorMovimentado : 0, // Certifica-se de que não seja nulo
        ];
    }
    
    // Método para excluir um aviso
    public function delete() {
        // Certifique-se de que o ID está presente na URL
        if (isset($_GET['id'])) {
            $avisoID = $_GET['id']; // Obtém o ID do aviso a ser excluído
    
            $admModel = new AvisosAdmModel();
            $admModel->deleteAviso($avisoID);
        }
    
        header('Location: /homeadm'); // Redireciona para a tela home após a exclusão
        exit();
    }
    
    
}
