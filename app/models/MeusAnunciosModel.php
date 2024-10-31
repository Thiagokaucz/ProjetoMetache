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
        $sql = "SELECT statusAquisicao, statusPagamentoVendedor
                FROM aquisicoes 
                WHERE produtoID = :produtoID 
                LIMIT 1";  // Limite para garantir apenas um resultado
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna o status da aquisição e pagamento
    }

    public function obterAquisicaoPorProduto($produtoID) {
        // Adicione valorProduto e valorFrete à consulta
        $sql = "SELECT aquisicaoID, chatID, statusAquisicao, statusPagamentoVendedor, valorProduto, valorFrete 
                FROM aquisicoes 
                WHERE produtoID = :produtoID 
                LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna a primeira aquisição encontrada ou false se não houver
    }
    
    
    // Função para buscar o chatID baseado no produtoID
    public function buscarChatIDPorProdutoID($produtoID) {
        $sql = "SELECT chatID 
                FROM aquisicoes 
                WHERE produtoID = :produtoID 
                LIMIT 1";  // Limite para garantir apenas um resultado
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
        $stmt->execute();
        
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC); // Retorna o resultado como um array associativo
        return $resultado ? $resultado['chatID'] : null; // Retorna o chatID ou null se não encontrado
    }

    // Função para obter um anúncio pelo ID
    public function obterAnuncioPorID($produtoID) {
        // Prepara a query para evitar injeção de SQL
        $sql = "SELECT * FROM produto WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);

        // Associa o parâmetro :produtoID ao valor
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);

        // Executa a query
        $stmt->execute();

        // Retorna o resultado
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Função para atualizar a disponibilidade do anúncio
    public function atualizarDisponibilidade($produtoID, $novaDisponibilidade) {
        $sql = "UPDATE produto SET disponibilidade = :disponibilidade WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);

        // Associa os parâmetros
        $stmt->bindParam(':disponibilidade', $novaDisponibilidade, PDO::PARAM_STR);
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);

        // Executa a query
        return $stmt->execute();
    }

    public function excluirAnuncioPorID($produtoID) {
        $sql = "DELETE FROM produto WHERE produtoID = :produtoID";
        $stmt = $this->conn->prepare($sql);
        
        // Associa o parâmetro :produtoID ao valor
        $stmt->bindParam(':produtoID', $produtoID, PDO::PARAM_INT);
    
        // Executa a query de exclusão
        return $stmt->execute();
    }
    
}
