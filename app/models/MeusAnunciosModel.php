<?php
require_once 'config/Database.php';

class MeusAnunciosModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    // Buscar produtos de um usuário específico (usuário logado)
    public function buscarProdutosPorUsuario($userID) {
        $sql = "SELECT produtoID, userID, categoriaID, titulo, condicao, descricao, disponibilidade, valor, locImagem, dataHoraPub, localizacao, visualizacao 
                FROM produto 
                WHERE userID = :userID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verificar se o produto está em aquisição
    public function verificarProdutoEmAquisicao($produtoID) {
        $sql = "SELECT COUNT(*) as total 
                FROM aquisicoes 
                WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'] > 0; // Retorna verdadeiro se o produto está em aquisição
    }
}
