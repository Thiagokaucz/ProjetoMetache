<?php
session_start();
<<<<<<< HEAD
<<<<<<< HEAD
=======

require_once 'app/models/HomeModel.php';
>>>>>>> develop
=======

require_once 'app/models/HomeModel.php';
>>>>>>> 8dd99ddb18599ff97171806917c64fa4cb65d2ec

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
<<<<<<< HEAD
        require_once 'app/views/header.php';
        require_once 'app/views/home.php';
=======
=======
        // Define o limite de anúncios que queremos mostrar
>>>>>>> 8dd99ddb18599ff97171806917c64fa4cb65d2ec
        $limit = 5;

        $anunciosRecentes = $this->model->getAnunciosRecentes($limit);
        $maisPesquisados = $this->model->getMaisPesquisados($limit);

        $categorias = $this->homeModel->getTodasCategorias();

        require_once 'app/views/header.php';
        include 'app/views/home.php';
<<<<<<< HEAD
>>>>>>> develop
=======
>>>>>>> 8dd99ddb18599ff97171806917c64fa4cb65d2ec
        require_once 'app/views/footer.php';
    }
}
?>
