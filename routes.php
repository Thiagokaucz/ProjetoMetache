<?php
$routes = [
    '/' => 'HomeController@index',
    '/sobre' => 'SobreController@index',
    '/login' => 'LoginController@login',
    '/logout' => 'LoginController@logout',
    '/register' => 'RegisterController@register',

    '/areaCliente' => 'AreaClienteController@index',
    '/entreEmContato' => 'EntreEmContatoController@index',
    '/servicos' => 'ServicosController@index',

];
?>
