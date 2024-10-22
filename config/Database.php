<?php
class Database {
    
    private $host = 'localhost'; 
    private $nomeDoBanco = 'projetoMetache';
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
    }
}
?>
