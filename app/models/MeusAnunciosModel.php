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
                WHERE userID = :userID 
                GROUP BY produtoID"; // Adiciona o GROUP BY para evitar duplicação por possíveis joins ou outras causas
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Verificar se o produto está em aquisição
    public function verificarProdutoEmAquisicao($produtoID) {
        $sql = "SELECT statusAquisicao 
                FROM aquisicoes 
                WHERE produtoID = :produtoID 
                LIMIT 1";  // Limite para garantir apenas um resultado
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna o status da aquisição
    }
    public function obterAquisicaoPorProduto($produtoID) {
        $sql = "SELECT aquisicaoID, chatID, statusAquisicao 
                FROM aquisicoes 
                WHERE produtoID = :produtoID LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna a primeira aquisição encontrada ou false se não houver
    }
    
    
}
