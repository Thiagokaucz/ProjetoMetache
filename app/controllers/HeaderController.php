<?php
session_start();
require_once 'app/models/HeaderModel.php';

class HeaderController {
    private $headerModel;

    public function __construct() {
        $this->headerModel = new HeaderModel();
    }

    public function contarNaoVisualizadas() {
        header('Content-Type: application/json'); 
        if (isset($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];
            $quantidade = $this->headerModel->contarNaoVisualizadas($userID);
            echo json_encode(['nao_visualizadas' => $quantidade]);
        } else {
            echo json_encode(['nao_visualizadas' => 0]);
        }
    }

    public function marcarTodasComoVisualizadas() {
        header('Content-Type: application/json'); 
        if (isset($_SESSION['user_id'])) {
            $userID = $_SESSION['user_id'];
            $this->headerModel->marcarTodasComoVisualizadas($userID);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'failed']);
        }
    }
}
