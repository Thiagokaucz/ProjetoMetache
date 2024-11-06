<?php
require_once 'config/Database.php'; 

class ProdutosPesquisaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }
    
    public function obterCategoriaID($nomeCategoria) {
        $sql = "SELECT categoriaID FROM categoria WHERE categoria = :categoria";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':categoria', $nomeCategoria);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['categoriaID'] : null;
    }
    
    public function buscarProdutos($categoriaNome, $localizacao, $termo, $offset, $limite) {
        $categoriaID = $this->obterCategoriaID($categoriaNome);

        $sql = "SELECT * FROM produto WHERE disponibilidade = 'disponível' AND localizacao = :localizacao AND (titulo LIKE :termo OR descricao LIKE :termo)";

        if ($categoriaNome !== 'Todos' && $categoriaID !== null) {
            $sql .= " AND categoriaID = :categoriaID";
        }

        $sql .= " LIMIT :limite OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        if ($categoriaNome !== 'Todos' && $categoriaID !== null) {
            $stmt->bindValue(':categoriaID', $categoriaID);
        }
        $stmt->bindValue(':localizacao', $localizacao);
        $stmt->bindValue(':termo', '%' . $termo . '%');
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarProdutos($categoriaNome, $localizacao, $termo) {
        $categoriaID = $this->obterCategoriaID($categoriaNome);
        $sql = "SELECT COUNT(*) FROM produto WHERE disponibilidade = 'disponível' AND localizacao = :localizacao AND (titulo LIKE :termo OR descricao LIKE :termo)";
        
        if ($categoriaNome !== 'Todos' && $categoriaID !== null) {
            $sql .= " AND categoriaID = :categoriaID";
        }

        $stmt = $this->conn->prepare($sql);
        if ($categoriaNome !== 'Todos' && $categoriaID !== null) {
            $stmt->bindValue(':categoriaID', $categoriaID);
        }
        $stmt->bindValue(':localizacao', $localizacao);
        $stmt->bindValue(':termo', '%' . $termo . '%');
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function obterCategorias() {
        $sql = "SELECT categoria FROM categoria";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obterRegioes() {
        $sql = "SELECT DISTINCT localizacao FROM produto";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
