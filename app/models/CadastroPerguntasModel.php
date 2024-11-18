<?php
require_once 'config/Database.php';

class CadastroPerguntasModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->obterConexao();
    }

    public function salvarPerguntas($userID, $pergunta1, $resposta1, $pergunta2, $resposta2) {
        $query = 'UPDATE usuario 
                  SET pergunta1 = :pergunta1, resposta1 = :resposta1, 
                      pergunta2 = :pergunta2, resposta2 = :resposta2 
                  WHERE userID = :userID';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':pergunta1', $pergunta1);
        $stmt->bindParam(':resposta1', $resposta1);
        $stmt->bindParam(':pergunta2', $pergunta2);
        $stmt->bindParam(':resposta2', $resposta2);

        return $stmt->execute();
    }
}
