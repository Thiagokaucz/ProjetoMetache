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
    '/ChatListaExcluir' => 'ChatListaController@excluirChat',

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
    '/receberProduto' => 'AquisicoesController@receberProduto',


    '/meusAnuncios' => 'MeusAnunciosController@mostrarAnuncios',

    '/CompraLinkChat' => 'CompraLinkChatController@mostrarDados',

    '/tratarCompra' => 'TratarCompraController@processarCompra',

    '/finalizarCompra' => 'FinalizarCompraController@processar',

    '/enviarProduto' => 'EnviarProdutoController@mostrarFormulario',
    '/enviarProdutoForm' => 'EnviarProdutoController@enviarProduto',

    '/editarProduto' => 'EditarProdutoController@editarProduto',

    '/alterarDisponibilidade' => 'MeusAnunciosController@alterarDisponibilidade',

    '/excluirAnuncio' => 'MeusAnunciosController@excluirAnuncio',

    '/VerificarCompraController' => 'VerificarCompraController@processarCompra',

    '/denunciarProduto' => 'DenunciaController@mostrarFormulario',  // Rota para o formulário
    '/enviarDenuncia' => 'DenunciaController@criarDenuncia',       // Rota para o envio do formulário

    '/admPagamentos' => 'AdmListaComprasController@exibirComprasPendentes',

    '/PagamentoAdm' => 'AdmPagamentoController@mostrarPagamento',

    '/pagar' => 'AdmPagamentoController@pagar',

];
