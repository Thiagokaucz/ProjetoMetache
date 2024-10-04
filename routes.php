<?php
$routes = [
    '/' => 'HomeController@index',              // Página inicial
    '/login' => 'LoginController@login',        // Página de login
    '/logout' => 'LoginController@logout',   
    '/cadastroUsuario' => 'CadastroController@cadastrar', // Página de cadastro
    '/home' => 'HomeController@index',          // Home após login
];
?>
