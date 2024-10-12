<?php
class Database {
    
    private $host; 
    private $db_nome;
    private $db_usuario; 
    private $db_senha; 
    
    public $conn;

    // Construtor que aceita parâmetros para a conexão
    public function __construct($host = 'localhost', $db_nome = 'metache', $db_usuario = 'root', $db_senha = '') {
        $this->host = $host; 
        $this->db_nome = $db_nome;
        $this->db_usuario = $db_usuario; 
        $this->db_senha = $db_senha; 
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_nome, $this->db_usuario, $this->db_senha);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $exception) {
            echo "Erro na conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
