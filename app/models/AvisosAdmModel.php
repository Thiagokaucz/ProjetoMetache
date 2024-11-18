<?php
require_once 'config/Database.php';

class AvisosAdmModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function getAvisos($usuarioID) {
        $query = 'SELECT a.nome AS nome_criador, av.* 
                  FROM avisosadm av 
                  JOIN administrador a ON av.usuario_criador = a.adminID 
                  WHERE av.usuario_destino = :usuario_destino 
                  ORDER BY av.data_criacao DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_destino', $usuarioID);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function deleteAviso($avisoID) {
        $query = 'DELETE FROM avisosadm WHERE avisoID = :avisoID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':avisoID', $avisoID);
        return $stmt->execute(); 
    }
    
}
