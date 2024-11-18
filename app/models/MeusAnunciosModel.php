<?php
require_once 'config/Database.php';

class MeusAnunciosModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function buscarProdutosPorUsuario($userID) {
        $sql = "SELECT produtoID, userID, categoriaID, titulo, condicao, descricao, disponibilidade, valor, locImagem, dataHoraPub, localizacao, visualizacao 
                FROM produto 
                WHERE userID = :userID 
                GROUP BY produtoID"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function verificarProdutoEmAquisicao($produtoID) {
        $sql = "SELECT statusAquisicao, statusPagamentoVendedor
                FROM aquisicoes 
                WHERE produtoID = :produtoID 
                LIMIT 1";  
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function obterAquisicaoPorProduto($produtoID) {
        $sql = "SELECT aquisicaoID, chatID, statusAquisicao, statusPagamentoVendedor, valorProduto, valorFrete 
                FROM aquisicoes 
                WHERE produtoID = :produtoID 
                LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    
    public function buscarChatIDPorProdutoID($produtoID) {
        $sql = "SELECT chatID 
                FROM aquisicoes 
                WHERE produtoID = :produtoID 
                LIMIT 1";  
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC); 
        return $resultado ? $resultado['chatID'] : null; 
    }

    public function obterAnuncioPorID($produtoID) {

        $sql = "SELECT * FROM produto WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarDisponibilidade($produtoID, $novaDisponibilidade) {
        $sql = "UPDATE produto SET disponibilidade = :disponibilidade WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':disponibilidade', $novaDisponibilidade, PDO::PARAM_STR);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);

        return $stmt->execute();
    }

public function excluirAnuncioPorID($produtoID) {

    $sql = "SELECT chatID FROM chat WHERE produtoID = :produtoID LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
    $stmt->execute();
    $chat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($chat) {

        $chatID = $chat['chatID'];

        $sql = "DELETE FROM linkcompra WHERE chatID = :chatID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT);
        $stmt->execute();

        $sql = "DELETE FROM notificacao WHERE chatID = :chatID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT);
        $stmt->execute();

        $sql = "DELETE FROM mensagem WHERE chatID = :chatID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT);
        $stmt->execute();

        $sql = "DELETE FROM chat WHERE chatID = :chatID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':chatID', $chatID, PDO::PARAM_INT);
        $stmt->execute();
    }

    $sql = "DELETE FROM produto WHERE produtoID = :produtoID";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
    return $stmt->execute();
}

    
}
