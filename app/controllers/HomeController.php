<?php
session_start();

require_once 'app/models/HomeModel.php';

class HomeController {
    
    private $model;

    public function __construct() {
        $database = new Database(); 
        $conn = $database->obterConexao();
        
        $this->model = new HomeModel($conn);
        $this->homeModel = new HomeModel($conn);

    }

    public function index() {
        $limit = 5;

        $anunciosRecentes = $this->model->getAnunciosRecentes($limit);
        $maisPesquisados = $this->model->getMaisPesquisados($limit);

        $categorias = $this->homeModel->getTodasCategorias();

        require_once 'app/views/header.php';
        include 'app/views/home.php';
        require_once 'app/views/footer.php';
    }
}
?>
