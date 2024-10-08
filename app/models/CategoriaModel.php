<?php
class CategoriaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getCategorias() {
        $query = "SELECT categoriaID, categoria FROM categoria";  // Certifique-se de que a tabela 'categoria' existe no banco de dados
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Retorna um array de categorias
    }
    
}
?>
