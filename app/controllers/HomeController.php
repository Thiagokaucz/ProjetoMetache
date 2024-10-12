<?php
session_start();

require_once 'app/models/HomeModel.php';
require_once 'config/Database.php';

class HomeController {
    
    private $model;

    // Construtor para inicializar o modelo
    public function __construct() {
        // Instancia a classe Database e obtém a conexão
        $database = new Database(); // Aqui você pode passar parâmetros se desejar
        $conn = $database->getConnection();
        
        // Passa a conexão para o HomeModel
        $this->model = new HomeModel($conn);
    }

    // Função que carrega os dados e a view
    public function index() {
        // Define o limite de anúncios que queremos mostrar
        $limit = 5;

        // Busca os anúncios recentes e os mais pesquisados com limite de 5
        $anunciosRecentes = $this->model->getAnunciosRecentes($limit);
        $maisPesquisados = $this->model->getMaisPesquisados($limit);

        // Passa os dados para a view
        require_once 'app/views/header.php';
        include 'app/views/home.php';
        require_once 'app/views/footer.php';
    }
}
?>
