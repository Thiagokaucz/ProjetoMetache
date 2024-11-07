<?php
require_once 'app/models/MeusAnunciosModel.php';
session_start();

class MeusAnunciosController {
    private $meusAnunciosModel;

    public function __construct() {
        $this->meusAnunciosModel = new MeusAnunciosModel();
    }

    public function mostrarAnuncios() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userID = $_SESSION['user_id'];
        // Buscar todos os produtos do usuário
        $anuncios = $this->meusAnunciosModel->buscarProdutosPorUsuario($userID);

        // Se não houver anúncios, inicializar como array vazio
        if (!$anuncios) {
            $anuncios = [];
        }

        // Para cada produto, buscar o status de aquisição e o chatID
        foreach ($anuncios as &$anuncio) {
            // Obter a aquisição do produto
            $aquisicao = $this->meusAnunciosModel->obterAquisicaoPorProduto($anuncio['produtoID']);
            
            // Buscar o chatID associado ao produto
            $chatID = $this->meusAnunciosModel->buscarChatIDPorProdutoID($anuncio['produtoID']);
            
            // Verificar se a aquisição foi encontrada
            if ($aquisicao) {
                $anuncio['statusAquisicao'] = $aquisicao['statusAquisicao'];
                $anuncio['chatID'] = $chatID; // Adiciona o chatID ao anúncio
            } else {
                $anuncio['statusAquisicao'] = 'Anunciado';
                $anuncio['chatID'] = $chatID; // Pode ser null se não houver aquisição
            }
        }

        //$aquisicao = $this->meusAnunciosModel->obterAquisicaoPorProduto($anuncio['produtoID']); // isso é gambi

        require_once 'app/views/header.php';
        require 'app/views/MeusAnuncios.php';
        require_once 'app/views/footerConfig.php';

        
    }

        // Função para alterar a disponibilidade do produto
        public function alterarDisponibilidade() {
            // Verifica se o ID do produto e a ação estão presentes na URL
            if (isset($_GET['id']) && isset($_GET['acao'])) {
                $produtoID = $_GET['id'];
                $acao = $_GET['acao'];
    
                // Obtém o user_id da sessão
                $user_id = $_SESSION['user_id']; // Supondo que o user_id está na sessão
    
                // Busca o produto pelo ID
                $anuncio = $this->meusAnunciosModel->obterAnuncioPorID($produtoID);
    
                // Verifica se o usuário logado é o dono do anúncio
                if ($anuncio && $anuncio['userID'] == $user_id) {
                    // Verifica a ação e define a nova disponibilidade
                    if ($acao === 'pausar') {
                        $novaDisponibilidade = 'pausado';
                    } elseif ($acao === 'liberar') {
                        $novaDisponibilidade = 'disponível';
                    } else {
                        echo "Ação inválida!";
                        exit;
                    }
    
                    // Atualiza a disponibilidade no banco de dados
                    $this->meusAnunciosModel->atualizarDisponibilidade($produtoID, $novaDisponibilidade);
    
                    // Redireciona para a página de anúncios
                    header("Location: /meusAnuncios");
                    exit;
                } else {
                    echo "Você não tem permissão para alterar este anúncio.";
                }
            } else {
                echo "ID ou Ação não especificados!";
            }
        }

        public function excluirAnuncio() {
            // Verifica se o ID do produto está presente na URL
            if (isset($_GET['id'])) {
                $produtoID = $_GET['id'];
                
                // Obtém o user_id da sessão
                $user_id = $_SESSION['user_id'];
        
                // Busca o anúncio pelo ID
                $anuncio = $this->meusAnunciosModel->obterAnuncioPorID($produtoID);
        
                // Verifica se o usuário logado é o dono do anúncio e se a disponibilidade permite a exclusão
                if ($anuncio && $anuncio['userID'] == $user_id && 
                   ($anuncio['disponibilidade'] === 'disponível' || $anuncio['disponibilidade'] === 'pausado')) {
                    
                    // Excluir o anúncio
                    $this->meusAnunciosModel->excluirAnuncioPorID($produtoID);
                    
                    // Redireciona para a página de anúncios
                    header("Location: /meusAnuncios");
                    exit;
                } else {
                    echo "Você não tem permissão para excluir este anúncio ou o anúncio não pode ser excluído.";
                }
            } else {
                echo "ID do anúncio não especificado!";
            }
        }
        
}
