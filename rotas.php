<?php
$rotas = [
    '/' => 'HomeController@index',
    
    '/login' => 'LoginController@login',   
    '/logout' => 'LoginController@logout',

    '/cadastroUsuario' => 'CadastroController@cadastrar',

    '/anunciar' => 'AnunciarProdutoController@index',
    '/criar-produto' => 'AnunciarProdutoController@criarProduto', 

    '/detalheProduto' => 'DetalheProdutoController@mostrarDetalhes', 

    '/chatLista' => 'ChatListaController@verificarUsuarioNoChat',

    '/chatCompra' => 'ChatMensagemController@chat', 
    '/sendMessage' => 'ChatMensagemController@sendMessage', 
    '/getMessagesAjax' => 'ChatMensagemController@getMessagesAjax', 

    '/notificacao' => 'NotificacaoController@mostrarNotificacoes',
    '/excluir' => 'NotificacaoController@excluirNotificacao',

];
