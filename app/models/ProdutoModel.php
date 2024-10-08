<?php
require_once 'app/models/UserModel.php';

class ProdutoModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    private function generateUUID() {
        return strtoupper(bin2hex(random_bytes(16)));
    }

    private function uploadFotos($files, $userID) {
        $targetDir = "uploads/";
        $userDir = $targetDir . $userID . '/';
        if (!file_exists($userDir)) {
            mkdir($userDir, 0777, true);
        }

        $fileNames = [];
        foreach ($files['name'] as $key => $name) {
            $uniqueName = $this->generateUUID() . '.' . pathinfo($name, PATHINFO_EXTENSION);
            $targetFile = $userDir . $uniqueName;

            if (move_uploaded_file($files['tmp_name'][$key], $targetFile)) {
                $fileNames[] = $targetFile;
            }
        }

        return implode(',', $fileNames);
    }

    public function criarProduto($postData, $files, $userID) {
        $categoriaID = $postData['categoria'];
        $titulo = $postData['titulo'];
        $condicao = $postData['condicao'];
        $descricao = $postData['descricao'];
        $valor = $postData['valor'];
        $localizacao = $postData['localizacao'];
        $dataHoraPub = date('Y-m-d H:i:s');
        $uploadedFotos = $this->uploadFotos($files['foto'], $userID);

        $query = "INSERT INTO produto 
                  (userID, categoriaID, titulo, condicao, descricao, valor, locImagem, dataHoraPub, localizacao) 
                  VALUES 
                  (:userID, :categoriaID, :titulo, :condicao, :descricao, :valor, :locImagem, :dataHoraPub, :localizacao)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':categoriaID', $categoriaID);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':condicao', $condicao);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':locImagem', $uploadedFotos);
        $stmt->bindParam(':dataHoraPub', $dataHoraPub);
        $stmt->bindParam(':localizacao', $localizacao);

        return $stmt->execute();
    }

    public function verificarUsuarioExiste($userID) {
        $query = "SELECT COUNT(*) FROM usuario WHERE userID = :userID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function verificarCategoriaExiste($categoriaID) {
        $query = "SELECT COUNT(*) FROM categoria WHERE categoriaID = :categoriaID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':categoriaID', $categoriaID);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}

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
