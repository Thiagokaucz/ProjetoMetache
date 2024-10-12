<?php
$rotas = [
    '/' => 'HomeController@index',//Home
    
    '/login' => 'LoginController@login',   
    '/logout' => 'LoginController@logout',//Deslogar

    '/cadastroUsuario' => 'CadastroController@cadastrar',

    '/anunciar' => 'AnunciarProdutoController@index',// Tela para anunciar um produto
    '/criar-produto' => 'AnunciarProdutoController@criarProduto', // Rota para processar o envio do anuncio

    '/detalheProduto' => 'DetalheProdutoController@mostrarDetalhes', // Alterado para o método correto

    '/chatLista' => 'ChatListaController@verificarUsuarioNoChat',

    '/chat' => 'ChatMensagemController@chat', // Adicione esta linha
    '/sendMessage' => 'ChatMensagemController@sendMessage', // Nova rota para enviar mensagens
    '/getMessagesAjax' => 'ChatMensagemController@getMessagesAjax', // Rota para buscar mensagens via AJAX

    '/notificacao' => 'NotificacaoController@mostrarNotificacoes',
    '/excluir' => 'NotificacaoController@excluirNotificacao',

];
