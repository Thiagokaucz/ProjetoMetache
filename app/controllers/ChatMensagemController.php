<?php
session_start();

require_once 'app/models/ChatMensagemModel.php';

class ChatMensagemController {
    
    private $ChatMensagemModel;
    
    public function __construct() {
        $this->ChatMensagemModel = new ChatMensagemModel();
    }

    private function formatarParaBanco($valor) {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        return (float)$valor;
    }

    private function formatarParaExibicao($valor) {
        return number_format($valor, 2, ',', '.');
    }

    public function chat() {
        if (isset($_GET['Produto'], $_GET['Origem'], $_GET['Tipo'])) {
            if (isset($_SESSION['user_id'])) {
                $produtoID = filter_input(INPUT_GET, 'Produto', FILTER_SANITIZE_NUMBER_INT);
                $origem = filter_input(INPUT_GET, 'Origem', FILTER_SANITIZE_STRING);
                $tipoID = filter_input(INPUT_GET, 'Tipo', FILTER_SANITIZE_STRING);
                $chatIdUrl = isset($_GET['chatID']) ? filter_input(INPUT_GET, 'chatID', FILTER_SANITIZE_NUMBER_INT) : null; 
                $userID = $_SESSION['user_id'];
        
                $_SESSION['produtoID'] = $produtoID;
                $_SESSION['origem'] = $origem;
                $_SESSION['tipoID'] = $tipoID;
                $_SESSION['chatID'] = $chatIdUrl;
    
                if ($origem === 'ListaChat') {
                    if ($tipoID === 'MinhasCompras') {
                        $chatId = $this->ChatMensagemModel->verificarChatComprador($produtoID, $userID);
                    } elseif ($tipoID === 'MinhasVendas') {
                        $chatId = $chatIdUrl;
                    }
                    $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);
                } elseif ($origem === 'DetalhesAnuncio' && $tipoID === 'IniciarChat') {
                    $vendedorID = $this->ChatMensagemModel->buscarUserIDPorProdutoID($produtoID);
                    if ($userID == $vendedorID) {
                        header('Location: /ErroCompraProduto');
                        exit();
                    } else {
    
                            $chatId = $this->ChatMensagemModel->verificarOuCriarChat($produtoID, $userID, $vendedorID);
                            
                            $existeChat = $this->ChatMensagemModel->verificarExistenciaChat($chatId);

                            if ($existeChat) {
                            } else {
                                $conteudoNotificacao = "Usuário " . $userID . " iniciou uma negociação no chat " . $chatId;
                                $statusCriouNotificacao = $this->ChatMensagemModel->criarNotificacao($userID, $vendedorID, $chatId, $conteudoNotificacao);
                                
                            }                                                                       

                            $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);

                        }
                }

                $vendedorNome = $this->ChatMensagemModel->getVendedorNomePorChatID($chatId);
                $compradorNome = $this->ChatMensagemModel->getCompradorNomePorChatID($chatId);
                $produtoDetalhes = $this->ChatMensagemModel->buscarProdutoPorID($produtoID);

                if ($tipoID == "IniciarChat" || $tipoID == "MinhasCompras") {
                    require_once 'app/views/header.php';
                    require_once 'app/views/chatMensagemCompra.php';
                    require_once 'app/views/footerConfig.php';
                } elseif ($tipoID == "MinhasVendas") {
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $chatId = $_POST['chatId'];
            $messageContent = $_POST['message'];
            $userId = $_SESSION['user_id'];
    
            $this->saveMessage($chatId, $messageContent, $userId);
    
            $produtoID = $_SESSION['produtoID'];
            $origem = $_SESSION['origem'];
            $tipoID = $_SESSION['tipoID'];
    
            header("Location: /chat?Produto=$produtoID&Origem=$origem&Tipo=$tipoID&chatID=$chatId");
            unset($_SESSION['origem'], $_SESSION['tipoID']);
            exit();
        } else {
            echo "Método não permitido.";
        }
    }
    
    private function saveMessage($chatId, $messageContent, $userId) {
        $database = new Database();
        $pdo = $database->obterConexao();
        
        $stmt = $pdo->prepare("INSERT INTO mensagem (conteudo, dataHora, chatID, userID) VALUES (:conteudo, NOW(), :chatID, :userID)");
        $stmt->bindParam(':conteudo', $messageContent);
        $stmt->bindParam(':chatID', $chatId);
        $stmt->bindParam(':userID', $userId);
        
        return $stmt->execute();
    }

    public function getMessagesAjax() {
        if (isset($_GET['id'])) {
            $chatId = $_GET['id'];
            $messages = $this->ChatMensagemModel->getMessagesByChatId($chatId);

            header('Content-Type: application/json');
            echo json_encode($messages);
            exit();
        } else {
            echo json_encode(["error" => "ID do chat não fornecido."]);
            exit();
        }
    }

public function enviarLinkCompra() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $chatId = filter_input(INPUT_POST, 'chatId', FILTER_SANITIZE_NUMBER_INT);
        $valorBrutoCompra = $this->formatarParaBanco($_POST['valorBrutoCompra']);
        $valorFrete = $this->formatarParaBanco($_POST['valorFrete']);
        $produtoID = $_SESSION['produtoID'];

        $statusProduto = $this->ChatMensagemModel->verificarDisponibilidadeProduto($produtoID);
        if ($statusProduto === 'vendido' || $statusProduto === 'pausado') {

                require_once 'app/views/header.php'; 
                require_once 'app/views/erroLinkCompra2.php';
                require_once 'app/views/footerConfig.php';

            return;
        }

        $linkExistente = $this->ChatMensagemModel->verificarLinkExistente($chatId);
        if ($linkExistente) {
            $dataHoraLink = new DateTime($linkExistente['dataHora']);
            $dataHoraAtual = new DateTime();
            $intervalo = $dataHoraAtual->diff($dataHoraLink);

            if ($intervalo->i < 1) {

                require_once 'app/views/header.php'; 
                require_once 'app/views/erroLinkCompra1.php';
                require_once 'app/views/footerConfig.php';

                return;
            } else {
                $this->ChatMensagemModel->excluirMensagemELinkCompra($linkExistente['linkCompraID']);
            }
        }

        $valorCompra = $valorBrutoCompra + $valorFrete;
        $statusLinkCompra = 'pendente';

        $linkCompraID = $this->ChatMensagemModel->salvarLinkCompra($chatId, $valorBrutoCompra, $valorCompra, $statusLinkCompra, $valorFrete, $produtoID);
        $conteudoMensagem = "Link de compra gerado: valor total R$ " . $this->formatarParaExibicao($valorCompra);
        $this->ChatMensagemModel->salvarMensagemComLinkCompra($chatId, $conteudoMensagem, $_SESSION['user_id'], $linkCompraID);

        header("Location: /chat?Produto={$_SESSION['produtoID']}&Origem={$_SESSION['origem']}&Tipo={$_SESSION['tipoID']}&chatID=$chatId");
        exit();
    } else {
        echo "Método não permitido.";
    }
}

}
