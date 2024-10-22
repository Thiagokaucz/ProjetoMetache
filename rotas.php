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

    '/chat' => 'ChatMensagemController@chat', 
    '/sendMessage' => 'ChatMensagemController@sendMessage', 
    '/getMessagesAjax' => 'ChatMensagemController@getMessagesAjax', 
    '/enviarLinkCompra' => 'ChatMensagemController@enviarLinkCompra',

    '/notificacao' => 'NotificacaoController@mostrarNotificacoes',
    '/excluir' => 'NotificacaoController@excluirNotificacao',

    '/PesquisarProdutosPor' => 'ProdutosPesquisaController@pesquisarProdutos',

    '/perfilUsuario' => 'PerfilUsuarioController@exibirDados',
    '/perfilUsuario/atualizar' => 'PerfilUsuarioController@atualizarDados',
    '/perfilUsuario/desativar' => 'PerfilUsuarioController@desativarUsuario',  // Alterada de 'deletar' para 'desativar'

    '/ajudaContato' => 'AjudaContatoController@index',
    '/dicasSeguranca' => 'DicasSegurancaController@index',

    '/minhasCompras' => 'AquisicoesController@mostrarAquisicoes',

    '/meusAnuncios' => 'MeusAnunciosController@mostrarAnuncios',

    '/CompraLinkChat' => 'CompraLinkChatController@mostrarDados',

    '/tratarCompra' => 'TratarCompraController@processarCompra',

    '/finalizarCompra' => 'FinalizarCompraController@processar',

    '/enviarProduto' => 'EnviarProdutoController@mostrarFormulario',
    '/enviarProdutoForm' => 'EnviarProdutoController@enviarProduto',

];
