<?php
class Database {
<<<<<<< HEAD
    private $host = 'localhost';
    private $db_name = 'metache'; // Substitua pelo nome do seu banco
    private $username = 'root'; // Usuário padrão
    private $password = ''; // Senha padrão
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erro na conexão: " . $exception->getMessage();
        }

        return $this->conn;
=======
    
    private $host = 'localhost'; 
    private $nomeDoBanco = 'metache';
    private $usuario = 'root'; 
    private $senha = ''; 
    
    public $conexao;

    public function obterConexao() {
        $this->conexao = null;

        try {
            $this->conexao = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->nomeDoBanco, $this->usuario, $this->senha);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $excecao) {
            echo "Erro na conexão: " . $excecao->getMessage();
        }
        return $this->conexao;
>>>>>>> develop
    }
}
?>
