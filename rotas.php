<?php
$rotas = [
    '/' => 'HomeController@index',
    
    '/login' => 'LoginController@login',   
    '/logout' => 'LoginController@logout',

    '/cadastroUsuario' => 'CadastroController@cadastrar',
    '/cadastroPerguntas' => 'CadastroPerguntasController@configurarPerguntas',

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
    '/perfilUsuario/desativar' => 'PerfilUsuarioController@desativarUsuario', 

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

    '/denunciarProduto' => 'DenunciaController@mostrarFormulario',  
    '/enviarDenuncia' => 'DenunciaController@criarDenuncia',       

    '/ListPagamentosAdm' => 'AdmListaComprasController@exibirComprasPendentes',

    '/PagamentoAdm' => 'AdmPagamentoController@mostrarPagamento',
    '/atualizarStatusDenuncia' => 'AdmPagamentoController@atualizarStatusDenuncia',

    '/pagar' => 'AdmPagamentoController@pagar',

    '/admlogin' => 'AdmLoginController@login',
    '/admlogout' => 'AdmLoginController@logout',

    '/admcadastrarusuario' => 'AdmCadastrarUsuarioController@mostrarFormularioCadastro',
    '/admcadastrar' => 'AdmCadastrarUsuarioController@cadastrar',

    '/homeadm' => 'AdmHomeController@index',
    '/deleteAviso' => 'AdmHomeController@delete',

    '/link' => 'DadosController@linkPage',
    '/dados' => 'DadosController@showData',

    '/pagamentoVendedor' => 'PagamentoVendedorController@realizarPagamento',

    '/cancelarCompra' => 'AdmCancelarCompraController@cancelarCompra',

    '/PosPagamento' => 'PagamentoVendedorController@atualizarStatusAdmMetache',

    '/contarNaoVisualizadas' => 'HeaderController@contarNaoVisualizadas',
    '/marcarTodasComoVisualizadas' => 'HeaderController@marcarTodasComoVisualizadas',

    '/TermosUso' => 'TermosController@mostrarTermos',

    '/sobre' => 'SobrePlataformaController@exibirInformacoes',

'/recuperarSenha/email' => 'RecuperarSenhaController@solicitarEmail',       
'/recuperarSenha/perguntas' => 'RecuperarSenhaController@validarPerguntas', 
'/recuperarSenha/novaSenha' => 'RecuperarSenhaController@redefinirSenha',   

'/comprasFinalizadasCanceladas' => 'AdmListaComprasFinalizadasCanceladasController@exibirComprasFinalizadasCanceladas',

'/atualizarStatusAquisicoes' => 'AquisicoesController@atualizarStatusAquisicoes',

'/uploadDocumentos' => 'DocumentoController@mostrarFormularioUpload',
'/anexarDocumentos' => 'DocumentoController@anexarDocumentos',

'/linkOAoth' => 'RetornoOAuthController@exibirLinkAutorizacao',
'/retornoOAuth' => 'RetornoOAuthController@retornoOAuth',

'/comprovante' => 'VisualizarDocumentosController@exibirDocumentos',

'/ErroCompraProduto' => 'NaoPodeComprarProdutoController@index',

'/politicasEmpresa' => 'PoliticasEmpresaController@index',

];
