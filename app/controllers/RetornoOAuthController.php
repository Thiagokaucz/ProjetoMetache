<?php

require_once 'app/models/RetornoOAuthModel.php';

session_start(); // Inicia a sessão para obter o user_id

class RetornoOAuthController
{
    private $client_id = '2443018850634328';
    private $client_secret = 'uj6RwxlygS8VzPQAe9zwU9TwB1eMegSE';
    private $redirect_uri = 'https://abalonrpg.com/retornoOAuth';
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    // Redireciona automaticamente para o Mercado Pago para autorização
    public function exibirLinkAutorizacao()
    {
        $link = "https://auth.mercadopago.com/authorization?client_id={$this->client_id}&response_type=code&redirect_uri={$this->redirect_uri}";
        header("Location: $link"); // Redireciona para a URL de autorização
        exit();
    }

    public function retornoOAuth()
    {
        $resultado = null;
        $erro = null;

        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $data = array(
                'grant_type' => 'authorization_code',
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => $code,
                'redirect_uri' => $this->redirect_uri
            );

            $ch = curl_init('https://api.mercadopago.com/oauth/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

            $response = curl_exec($ch);
            curl_close($ch);

            if ($response !== false) {
                $token_data = json_decode($response, true);

                if (isset($token_data['access_token'])) {
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $token = $token_data['access_token'];
                        
                        $resultado = $this->usuarioModel->atualizarToken($user_id, $token);
                        
                        if (!$resultado) {
                            $erro = "Erro ao salvar o token no banco de dados.";
                        }
                    } else {
                        $erro = "User ID não encontrado na sessão.";
                    }
                } else {
                    $erro = "Erro ao obter o token de acesso.";
                }
            } else {
                $erro = "Falha na comunicação com a API do Mercado Pago.";
            }
        } else {
            $erro = "Parâmetro 'code' não encontrado na URL.";
        }

        // Carrega a visualização e passa os dados
        include 'app/views/retornoOAuthView.php';
    }
}
