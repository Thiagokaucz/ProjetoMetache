<?php
$rotas = [
    '/' => 'HomeController@index',//Home
    '/login' => 'LoginController@login',   
    '/logout' => 'LoginController@logout',//Deslogar
    '/cadastroUsuario' => 'CadastroController@cadastrar',

    '/anunciar' => 'AnunciarProdutoController@index',// Tela para anunciar um produto
    '/criar-produto' => 'AnunciarProdutoController@criarProduto', // Rota para processar o envio do anuncio

    '/chatLista' => 'ChatController@verificarUsuarioNoChat',
    '/detalheProduto' => 'DetalheProdutoController@mostrarDetalhes', // Alterado para o método correto

];
