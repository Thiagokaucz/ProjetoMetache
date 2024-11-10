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
            if (isset($_SESSION['user_id'])) { // Verifica se o usuário está logado
    
                // Sanitiza os dados recebidos pela URL
                $produtoID = filter_input(INPUT_GET, 'Produto', FILTER_SANITIZE_NUMBER_INT);
                $origem = filter_input(INPUT_GET, 'Origem', FILTER_SANITIZE_STRING);
                $tipoID = filter_input(INPUT_GET, 'Tipo', FILTER_SANITIZE_STRING);
                $userID = $_SESSION['user_id'];
    
                // Armazenando as variáveis em sessão
                $_SESSION['produtoID'] = $produtoID;
                $_SESSION['origem'] = $origem;
                $_SESSION['tipoID'] = $tipoID;
    
                // Lógica para validar com base na origem
                if ($origem === 'ListaChat') {
                    if ($tipoID === 'MinhasCompras') {
                        //echo "Chat para o comprador";
    
                        // Verifica ou cria o chat
                        $chatId = $this->ChatMensagemModel->verificarChatComprador($produtoID, $userID);
    
                        $chatId= filter_input(INPUT_GET, 'chatID', FILTER_SANITIZE_STRING);

                        // Busca as mensagens desse chat
                        $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);
    
                    } elseif ($tipoID === 'MinhasVendas') {
                        //echo "Chat para o vendedor";
    
                        // Verifica ou cria o chat
                        $chatId = $this->ChatMensagemModel->verificarChatVendedor($produtoID, $userID);
    
                        $chatId= filter_input(INPUT_GET, 'chatID', FILTER_SANITIZE_STRING);

                        // Busca as mensagens desse chat
                        $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);
    
                    } else {
                        //echo "Tipo desconhecido na origem ListaChat";
                    }
    
                } elseif ($origem === 'DetalhesAnuncio') {
                    if ($tipoID === 'IniciarChat') {
    
                        $vendedorID = $this->ChatMensagemModel->buscarUserIDPorProdutoID($produtoID);
    
                        if ($userID == $vendedorID) {
                            header('Location: /ErroCompraProduto');
                            exit();
                        } else {
                            //echo "Chat que vem dos detalhes do anúncio";
    
                            // Verifica ou cria o chat
                            $chatId = $this->ChatMensagemModel->verificarOuCriarChat($produtoID, $userID, $vendedorID);
                            
                            $existeChat = $this->ChatMensagemModel->verificarExistenciaChat($chatId);

                            if ($existeChat) {
                                //echo "O chat existe!";
                            } else {
                                //echo "O chat não existe!";
                                // Se um chat foi encontrado ou criado, cria a notificação
                                $conteudoNotificacao = "Usuário " . $userID . " iniciou uma negociação no chat " . $chatId;
                                $statusCriouNotificacao = $this->ChatMensagemModel->criarNotificacao($userID, $vendedorID, $chatId, $conteudoNotificacao);
                                
                            }                                                                       

                            // Busca as mensagens desse chat
                            $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);

                        }
    
                    } else {
                        echo "Tipo desconhecido na origem DetalhesAnuncio";
                    }
                } else {
                    echo "Origem desconhecida";
                }
                
                $tipoChat = $_GET['Tipo'];
                //echo $tipoChat;

                $vendedorNome = $this->ChatMensagemModel->getVendedorNomePorChatID($chatId);
                $compradorNome = $this->ChatMensagemModel->getCompradorNomePorChatID($chatId);

                //echo "valor:" . $vendedorNome . $compradorNome;
                            //--------------------------------------------------------------------------------------
                            // Buscando os dados do produto
                            $produtoDetalhes = $this->ChatMensagemModel->buscarProdutoPorID($produtoID);
                            //--------------------------------------------------------------------------------------

                if ($tipoChat == "IniciarChat" || $tipoChat == "MinhasCompras") {
                    // Carrega as views apropriadas
                    require_once 'app/views/header.php';
                    require_once 'app/views/chatMensagemCompra.php'; // Chama a tela passando as mensagens
                    require_once 'app/views/footerConfig.php';
                
                } elseif ($tipoChat == "MinhasVendas") {
                    // Carrega as views apropriadas
                    require_once 'app/views/header.php';
                    require_once 'app/views/chatMensagemVenda.php'; 
                    require_once 'app/views/footerConfig.php';
                }                

    
            } else {
                header('Location: /login');
                exit();
            }
        } else {
            echo "Parâmetros obrigatórios não fornecidos.";
        }
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
            header("Location: /chat?Produto=$produtoID&Origem=$origem&Tipo=$tipoID&chatID=$chatId");
            
            // Remove as variáveis de sessão específicas
            //unset($_SESSION['produtoID']);
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

    public function enviarLinkCompra() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $chatId = filter_input(INPUT_POST, 'chatId', FILTER_SANITIZE_NUMBER_INT);
            $valorBrutoCompra = filter_input(INPUT_POST, 'valorBrutoCompra', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $valorFrete = filter_input(INPUT_POST, 'valorFrete', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $produtoID = $_SESSION['produtoID'];

            // Verifica se já existe um link pendente para o mesmo chat
            $linkExistente = $this->ChatMensagemModel->verificarLinkExistente($chatId);
    
            if ($linkExistente) {
                // Verifica se já passou 1 minuto desde a criação do link
                $dataHoraLink = new DateTime($linkExistente['dataHora']);
                $dataHoraAtual = new DateTime();
                $intervalo = $dataHoraAtual->diff($dataHoraLink);
    
                if ($intervalo->i < 1) {
                    // Se não passou 1 minuto, não permite a criação do novo link
                    echo "Já existe um link pendente. Tente novamente mais tarde.";
                    return; // Interrompe a execução
                } else {

                    $this->ChatMensagemModel->excluirMensagemELinkCompra($linkExistente['linkCompraID']);

                    // Se já passou 1 minuto, atualiza o status do link existente para cancelado
                    //$this->ChatMensagemModel->atualizarStatusLink($linkExistente['linkCompraID'], 'cancelado');
                }
            }
    
            // Calcular o valor total da compra
            $valorCompra = $valorBrutoCompra + $valorFrete;
            $statusLinkCompra = 'pendente'; // Definindo um status inicial

            // Inserir os dados na tabela 'linkcompra' e obter o ID do link gerado
            $linkCompraID = $this->ChatMensagemModel->salvarLinkCompra($chatId, $valorBrutoCompra, $valorCompra, $statusLinkCompra, $valorFrete, $produtoID); // Passa o produtoID
    
            // Criar a mensagem com o ID do link de compra
            $conteudoMensagem = "Link de compra gerado: valor total R$ " . number_format($valorCompra, 2, ',', '.');
    
            // Salvar a mensagem na tabela 'mensagem', incluindo o ID do link de compra na coluna 'linkcompra'
            $this->ChatMensagemModel->salvarMensagemComLinkCompra($chatId, $conteudoMensagem, $_SESSION['user_id'], $linkCompraID);
    
            // Redirecionar de volta ao chat
            header("Location: /chat?Produto={$_SESSION['produtoID']}&Origem={$_SESSION['origem']}&Tipo={$_SESSION['tipoID']}&chatID=$chatId");
            exit();
        } else {
            echo "Método não permitido.";
        }
    }
    
    
    
    
}
