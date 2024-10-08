<?php
session_start();

class ChatController {
    public function index() {
        require_once 'app/views/header.php';
        require_once 'app/views/chat.php';
        require_once 'app/views/footer.php';
    }
}
?>
