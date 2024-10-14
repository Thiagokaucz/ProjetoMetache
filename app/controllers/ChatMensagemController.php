<?php
session_start();

require_once 'app/models/ChatMensagemModel.php'; // Inclua o arquivo do model

class ChatMensagemController {
    
    private $ChatMensagemModel;
    
    public function __construct() {

        $this->ChatMensagemModel = new ChatMensagemModel();
    }

    public function chat() {
        // Verifica se os parâmetros necessários foram passados na URL
        if (isset($_GET['Produto'], $_GET['Origem'], $_GET['Tipo'])) {
    
            $produtoID = $_GET['Produto'];
            $origem = $_GET['Origem'];    
            $tipoID = $_GET['Tipo'];     
            $userID = $_SESSION['user_id']; 

            // Armazenando as variáveis em sessão
            $_SESSION['produtoID'] = $produtoID;
            $_SESSION['origem'] = $origem;
            $_SESSION['tipoID'] = $tipoID;
    
            // Exibe informações para debug
            //echo "ID do produto: " . $produtoID . "<br>";
            //echo "Origem: " . $origem . "<br>";
            //echo "Tipo: " . $tipoID . "<br>";
            //echo "ID da sessão do usuário: " . $userID . "<br>";
    
            // Lógica para validar com base na origem
            if ($origem == 'ListaChat') {
                if ($tipoID == 'MinhasCompras') {
                    echo "Chat para o comprador";

                    // Verifica ou cria o chat
                    $chatId = $this->ChatMensagemModel->verificarChatComprador($produtoID, $userID);

                    // Busca as mensagens desse chat
                    $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);

                } elseif ($tipoID == 'MinhasVendas') {
                    echo "Chat para o vendedor";

                    // Verifica ou cria o chat
                    $chatId = $this->ChatMensagemModel->verificarChatVendedor($produtoID, $userID);

                    // Busca as mensagens desse chat
                    $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);

                } else {
                    echo "Tipo desconhecido na origem ListaChat";
                }
    
            } elseif ($origem == 'DetalhesAnuncio') {
                if ($tipoID == 'IniciarChat') {

                    $vendedorID = $this->ChatMensagemModel->buscarUserIDPorProdutoID($produtoID);

                    if ($userID == $vendedorID){
                        echo "Nao pode comprar o seu proprio produto senhor!";
                        exit();

                    }else{
                        echo "Chat que vem dos detalhes do anuncio";

                        // Verifica ou cria o chat
                        $chatId = $this->ChatMensagemModel->verificarOuCriarChat($produtoID, $userID, $vendedorID);

                        // Busca as mensagens desse chat
                        $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);
                    }

                } else {
                    echo "Origem desconhecida";
                }
            } else {
                echo "Origem desconhecida";
            }
        } else {
            echo "Parâmetros obrigatórios não fornecidos.";
        }
    
            // Carrega as views apropriadas
             require_once 'app/views/header.php';
             require_once 'app/views/chatMensagem.php'; // Chama a tela passando as mensagens
             require_once 'app/views/footer.php';
    
    }
    
    

    public function sendMessage() {
        // Verifica se a requisição é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $chatId = $_POST['chatId'];
            $messageContent = $_POST['message'];
            $userId = $_SESSION['user_id'];
    
            // Insere a mensagem na tabela
            $this->saveMessage($chatId, $messageContent, $userId);
    
            // Obtendo as variáveis de sessão
            $produtoID = $_SESSION['produtoID'];
            $origem = $_SESSION['origem'];
            $tipoID = $_SESSION['tipoID'];
    
            // Redireciona de volta para a página do chat
            header("Location: /chat?Produto=$produtoID&Origem=$origem&Tipo=$tipoID");
            
            // Remove as variáveis de sessão específicas
            unset($_SESSION['produtoID']);
            unset($_SESSION['origem']);
            unset($_SESSION['tipoID']);
            
            exit(); // Sempre chame exit após redirecionar
        } else {
            echo "Método não permitido.";
        }
    }
    
    

    // Método para salvar a mensagem no banco de dados
    private function saveMessage($chatId, $messageContent, $userId) {
        $database = new Database();
        $pdo = $database->obterConexao();
        
        $stmt = $pdo->prepare("INSERT INTO mensagem (conteudo, dataHora, chatID, userID) VALUES (:conteudo, NOW(), :chatID, :userID)");
        $stmt->bindParam(':conteudo', $messageContent);
        $stmt->bindParam(':chatID', $chatId);
        $stmt->bindParam(':userID', $userId);
        
        return $stmt->execute(); // Executa a query e retorna o resultado
    }

    // Método para obter as mensagens via AJAX
    public function getMessagesAjax() {
        // Verifica se o ID do chat foi passado via requisição GET
        if (isset($_GET['id'])) {
            $chatId = $_GET['id'];

            // Busca as mensagens desse chat
            $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);

            // Retorna as mensagens como JSON
            header('Content-Type: application/json');
            echo json_encode($messages);
            exit(); // Sempre chame exit após enviar a resposta
        } else {
            echo json_encode(["error" => "ID do chat não fornecido."]);
            exit();
        }
    }
}
