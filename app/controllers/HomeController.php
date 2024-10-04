<?php
session_start();

class HomeController {
    public function index() {
        require_once 'app/views/header.php';
        require_once 'app/views/home.php';
        require_once 'app/views/footer.php';
    }
}
?>
