<?php
session_start();
<<<<<<< HEAD
=======

require_once 'app/models/HomeModel.php';
>>>>>>> develop

class HomeController {
    
    private $model;

    public function __construct() {
        $database = new Database(); 
        $conn = $database->obterConexao();
        
        $this->model = new HomeModel($conn);
        $this->homeModel = new HomeModel($conn);

    }

    public function index() {
<<<<<<< HEAD
        require_once 'app/views/header.php';
        require_once 'app/views/home.php';
=======
        $limit = 5;

        $anunciosRecentes = $this->model->getAnunciosRecentes($limit);
        $maisPesquisados = $this->model->getMaisPesquisados($limit);

        $categorias = $this->homeModel->getTodasCategorias();

        require_once 'app/views/header.php';
        include 'app/views/home.php';
>>>>>>> develop
        require_once 'app/views/footer.php';
    }
}
?>
