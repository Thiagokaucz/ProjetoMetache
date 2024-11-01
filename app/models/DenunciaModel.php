<?php
require_once 'config/Database.php';

class DenunciaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }


    public function criarDenuncia($aquisicaoID, $motivo) {
        $query = "INSERT INTO denuncias (aquisicaoID, motivo, status) 
                  VALUES (:aquisicaoID, :motivo, 'não verificada')";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aquisicaoID', $aquisicaoID, PDO::PARAM_INT);
        $stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
