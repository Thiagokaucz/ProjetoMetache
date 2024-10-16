<?php
require_once 'config/Database.php'; 

class ProdutosPesquisaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }
    
        // Método para buscar o categoriaID a partir do nome da categoria
        public function obterCategoriaID($nomeCategoria) {
            $sql = "SELECT categoriaID FROM categoria WHERE categoria = :categoria";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':categoria', $nomeCategoria);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ? $result['categoriaID'] : null; // Retorna o ID ou null se não encontrar
        }
    
        public function buscarProdutos($categoriaNome, $localizacao, $termo) {
            // Primeiro, busque o categoriaID usando o nome da categoria
            $categoriaID = $this->obterCategoriaID($categoriaNome);
            
            // Prepare a base da consulta SQL
            $sql = "SELECT * FROM produto WHERE localizacao = :localizacao AND (titulo LIKE :termo OR descricao LIKE :termo)";
            
            // Se a categoria não for "Todos", adicione o filtro
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
        
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function obterCategorias() {
            $sql = "SELECT categoria FROM categoria"; // Ajuste o nome da coluna se necessário
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function obterRegioes() {
            $sql = "SELECT DISTINCT localizacao FROM produto"; // Assumindo que a coluna localizacao está na tabela produto
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN); // Retorna uma lista simples de regiões
        }
        
    }
    