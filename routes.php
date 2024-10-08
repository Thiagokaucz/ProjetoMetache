<?php
$routes = [
    '/' => 'HomeController@index',          // Home após login
    '/login' => 'LoginController@login',        // Página de login
    '/logout' => 'LoginController@logout',   // Usamos para deslogar
    '/cadastroUsuario' => 'CadastroController@cadastrar', // Página de cadastro

    '/anunciar' => 'AnunciarProdutoController@index',          // Tela para anunciar um produto
    '/chat' => 'ChatController@index',          // Chat

    '/criar-produto' => 'AnunciarProdutoController@criarProduto', // Rota para processar o envio do anúncio

];
?>
